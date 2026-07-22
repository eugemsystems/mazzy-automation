<?php

namespace Webkul\Netcash\Http\Controllers;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Netcash\Payment\Netcash;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Shop\Http\Controllers\Controller;

class NetcashController extends Controller
{
    /**
     * Payment success status constant.
     */
    public const PAYMENT_SUCCESS = 'success';

    /**
     * Netcash transaction status check endpoint, used to independently verify a
     * transaction server-side, since the Notify/Accept postback carries no signature.
     */
    public const STATUS_CHECK_URL = 'https://ws.netcash.co.za/PayNow/TransactionStatus/Check';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected InvoiceRepository $invoiceRepository,
        protected Netcash $netcash,
    ) {}

    /**
     * Redirect to Netcash Pay Now hosted payment page.
     *
     * @return View|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        if (! $this->netcash->hasValidCredentials()) {
            session()->flash('error', trans('netcash::app.response.provide-credentials'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $cart = Cart::getCart();

        if (! $cart) {
            session()->flash('error', trans('netcash::app.response.cart-not-found'));

            return redirect()->route('shop.checkout.cart.index');
        }

        return view('netcash::checkout.redirect', [
            'paymentUrl' => Netcash::PAYMENT_URL,
            'paymentData' => $this->netcash->getPaymentData($cart),
        ]);
    }

    /**
     * Handle the browser return after a successful payment (Accept URL).
     *
     * This is a UX-only step — it does not mark the order as paid. The Notify
     * webhook (below) is the only trusted source for confirming payment,
     * since Netcash does not sign its postbacks.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept()
    {
        $response = request()->all();

        $order = $this->processPayment($response) ?? $this->findExistingOrder($response);

        if (! $order) {
            session()->flash('error', trans('netcash::app.response.order-creation-failed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        session()->flash('order_id', $order->id);

        session()->flash('success', trans('netcash::app.response.payment-success'));

        return redirect()->route('shop.checkout.onepage.success');
    }

    /**
     * Handle the browser return after a declined/cancelled payment (Decline URL).
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline()
    {
        session()->flash('error', trans('netcash::app.response.payment-failed'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Handle Netcash's authoritative server-to-server Notify webhook.
     *
     * Netcash requires the literal string "OK" to be printed back to
     * acknowledge receipt of the notification.
     *
     * @return Response
     */
    public function notify()
    {
        $this->processPayment(request()->all());

        return response('OK', 200);
    }

    /**
     * Verify and process a Netcash Pay Now callback, creating the order/invoice
     * on first successful confirmation. Safe to call more than once for the
     * same transaction (accept + notify both hit this, often almost
     * simultaneously) — concurrent calls are serialized via a per-transaction
     * lock so only the first one creates the order; the rest reuse it.
     *
     * @param  array  $response
     * @return \Webkul\Sales\Contracts\Order|null
     */
    protected function processPayment(array $response)
    {
        $cartId = $response['Extra1'] ?? null;

        $requestTrace = $response['RequestTrace'] ?? null;

        if (! $cartId || ! $requestTrace) {
            return null;
        }

        $lock = Cache::lock("netcash-transaction-{$requestTrace}", 30);

        try {
            return $lock->block(10, function () use ($cartId, $response) {
                if ($existingOrder = $this->findExistingOrder($response)) {
                    return $existingOrder;
                }

                $cart = $this->cartRepository->find($cartId);

                if (! $cart || ! $cart->is_active) {
                    return null;
                }

                if (! $this->verifyTransaction($response)) {
                    Log::warning('Netcash Pay Now: transaction could not be verified.', $response);

                    return null;
                }

                try {
                    Cart::setCart($cart);

                    Cart::collectTotals();

                    $data = (new OrderResource($cart))->jsonSerialize();

                    $data['payment']['additional'] = [
                        'netcash_reference' => $response['Reference'] ?? '',
                        'netcash_request_trace' => $response['RequestTrace'] ?? '',
                        'netcash_method' => $response['Method'] ?? '',
                    ];

                    $order = $this->orderRepository->create($data);

                    $this->orderRepository->update(['status' => 'processing'], $order->id);

                    if ($order->canInvoice()) {
                        $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

                        $this->orderTransactionRepository->create([
                            'transaction_id' => $response['RequestTrace'] ?? '',
                            'status' => self::PAYMENT_SUCCESS,
                            'type' => $order->payment->method,
                            'payment_method' => $order->payment->method,
                            'order_id' => $order->id,
                            'invoice_id' => $invoice->id,
                            'amount' => $response['Amount'] ?? $order->base_grand_total,
                            'data' => json_encode($response),
                        ]);
                    }

                    Cart::deActivateCart();

                    return $order;
                } catch (\Exception $e) {
                    report($e);

                    return null;
                }
            });
        } catch (LockTimeoutException $e) {
            return $this->findExistingOrder($response);
        }
    }

    /**
     * Independently verify a Pay Now transaction against Netcash's Transaction
     * Status Check service. Necessary because Netcash's Accept/Notify postback
     * fields are not signed — trusting the raw POST body alone would let anyone
     * forge a "TransactionAccepted=true" request.
     *
     * @param  array  $response
     * @return bool
     */
    protected function verifyTransaction(array $response)
    {
        if (
            ($response['TransactionAccepted'] ?? null) !== 'true'
            || empty($response['RequestTrace'])
        ) {
            return false;
        }

        try {
            $check = Http::get(self::STATUS_CHECK_URL, [
                'RequestTrace' => $response['RequestTrace'],
            ])->json();
        } catch (\Exception $e) {
            report($e);

            return false;
        }

        return ($check['TransactionAccepted'] ?? false) === true
            && (string) ($check['Reference'] ?? '') === (string) ($response['Reference'] ?? '');
    }

    /**
     * Look up an order already created for this transaction, for the case
     * where the async Notify webhook won the race and processed the payment
     * before the browser's Accept redirect arrived (so the cart is already
     * inactive by the time accept() runs).
     *
     * @param  array  $response
     * @return \Webkul\Sales\Contracts\Order|null
     */
    protected function findExistingOrder(array $response)
    {
        if (empty($response['RequestTrace'])) {
            return null;
        }

        $transaction = $this->orderTransactionRepository->findOneWhere([
            'transaction_id' => $response['RequestTrace'],
        ]);

        if (! $transaction) {
            return null;
        }

        return $this->orderRepository->find($transaction->order_id);
    }

    /**
     * Prepare invoice data.
     *
     * @param  object  $order
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }
}
