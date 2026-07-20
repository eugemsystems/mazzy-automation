<?php

namespace Webkul\Netcash\Payment;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webkul\Checkout\Facades\Cart;
use Webkul\Payment\Payment\Payment;

class Netcash extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'netcash';

    /**
     * Pay Now hosted payment page endpoint.
     *
     * @var string
     */
    const PAYMENT_URL = 'https://paynow.netcash.co.za/site/paynow.aspx';

    /**
     * Default software vendor key, used by anyone who is not a registered Netcash ISV.
     *
     * @var string
     */
    const DEFAULT_VENDOR_KEY = '24ade73c-98cf-47b3-99be-cc7b867b3080';

    /**
     * Get redirect URL for Netcash Pay Now.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('netcash.redirect');
    }

    /**
     * Check if payment method is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return parent::isAvailable() && $this->hasValidCredentials();
    }

    /**
     * Get payment method title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getConfigData('title') ?? trans('netcash::app.title');
    }

    /**
     * Get payment method description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getConfigData('description') ?? trans('netcash::app.description');
    }

    /**
     * Get payment method image/logo.
     *
     * @return string|null
     */
    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url ? Storage::url($url) : bagisto_asset('images/netcash.png', 'shop');
    }

    /**
     * Get the Pay Now service key from configuration.
     *
     * @return string|null
     */
    public function getServiceKey()
    {
        return $this->getConfigData('service_key');
    }

    /**
     * Validate merchant credentials.
     *
     * @return bool
     */
    public function hasValidCredentials()
    {
        return ! empty($this->getServiceKey());
    }

    /**
     * Generate the Pay Now form fields for the given cart.
     *
     * @param  \Webkul\Checkout\Contracts\Cart|null  $cart
     * @return array
     */
    public function getPaymentData($cart = null)
    {
        if (! $cart) {
            $cart = Cart::getCart();
        }

        return [
            'm1' => $this->getServiceKey(),
            'm2' => self::DEFAULT_VENDOR_KEY,
            'p2' => $this->generateReference(),
            'p3' => Str::limit('Order #'.$cart->id, 50, ''),
            'p4' => number_format($cart->base_grand_total, 2, '.', ''),
            'Budget' => 'Y',
            'm4' => $cart->id,
            'm9' => $cart->customer_email ?? '',
        ];
    }

    /**
     * Generate a unique, single-use transaction reference (Netcash field p2, max 25 chars).
     *
     * @return string
     */
    public function generateReference()
    {
        return Str::limit(uniqid('NC'), 25, '');
    }
}
