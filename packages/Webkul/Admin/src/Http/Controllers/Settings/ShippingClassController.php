<?php

namespace Webkul\Admin\Http\Controllers\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Settings\ShippingClassesDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\ShippingClassRequest;
use Webkul\Shipping\Repositories\ShippingClassRepository;

class ShippingClassController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ShippingClassRepository $shippingClassRepository) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(ShippingClassesDataGrid::class)->process();
        }

        return view('admin::settings.shipping-classes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin::settings.shipping-classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(ShippingClassRequest $request)
    {
        Event::dispatch('shipping.shipping_class.create.before');

        $data = $request->only(['code', 'name', 'description', 'status']);

        $data['status'] = $request->input('status') ? 1 : 0;

        $shippingClass = $this->shippingClassRepository->create($data);

        Event::dispatch('shipping.shipping_class.create.after', $shippingClass);

        session()->flash('success', trans('admin::app.settings.shipping-classes.create-success'));

        return redirect()->route('admin.settings.shipping_classes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(int $id)
    {
        $shippingClass = $this->shippingClassRepository->findOrFail($id);

        return view('admin::settings.shipping-classes.edit', compact('shippingClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(ShippingClassRequest $request, int $id)
    {
        Event::dispatch('shipping.shipping_class.update.before', $id);

        $data = $request->only(['code', 'name', 'description', 'status']);

        $data['status'] = $request->input('status') ? 1 : 0;

        $shippingClass = $this->shippingClassRepository->update($data, $id);

        Event::dispatch('shipping.shipping_class.update.after', $shippingClass);

        session()->flash('success', trans('admin::app.settings.shipping-classes.update-success'));

        return redirect()->route('admin.settings.shipping_classes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->shippingClassRepository->findOrFail($id);

        try {
            Event::dispatch('shipping.shipping_class.delete.before', $id);

            $this->shippingClassRepository->delete($id);

            Event::dispatch('shipping.shipping_class.delete.after', $id);

            return new JsonResponse([
                'message' => trans('admin::app.settings.shipping-classes.delete-success'),
            ]);
        } catch (\Exception $e) {
            report($e);
        }

        return new JsonResponse([
            'message' => trans('admin::app.settings.shipping-classes.delete-failed'),
        ], 500);
    }
}
