<?php

namespace Webkul\Admin\Http\Controllers\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Settings\ShippingZonesDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\ShippingZoneRequest;
use Webkul\Core\Repositories\CountryStateRepository;
use Webkul\Shipping\Repositories\ShippingZoneRepository;

class ShippingZoneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ShippingZoneRepository $shippingZoneRepository,
        protected CountryStateRepository $countryStateRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(ShippingZonesDataGrid::class)->process();
        }

        return view('admin::settings.shipping-zones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin::settings.shipping-zones.create', [
            'provinces' => $this->getProvinces(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(ShippingZoneRequest $request)
    {
        Event::dispatch('shipping.shipping_zone.create.before');

        $zone = $this->shippingZoneRepository->create($this->prepareData($request));

        $this->syncFallback($zone);

        Event::dispatch('shipping.shipping_zone.create.after', $zone);

        session()->flash('success', trans('admin::app.settings.shipping-zones.create-success'));

        return redirect()->route('admin.settings.shipping_zones.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(int $id)
    {
        $shippingZone = $this->shippingZoneRepository->findOrFail($id);

        return view('admin::settings.shipping-zones.edit', [
            'shippingZone' => $shippingZone,
            'provinces' => $this->getProvinces(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(ShippingZoneRequest $request, int $id)
    {
        Event::dispatch('shipping.shipping_zone.update.before', $id);

        $zone = $this->shippingZoneRepository->update($this->prepareData($request), $id);

        $this->syncFallback($zone);

        Event::dispatch('shipping.shipping_zone.update.after', $zone);

        session()->flash('success', trans('admin::app.settings.shipping-zones.update-success'));

        return redirect()->route('admin.settings.shipping_zones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->shippingZoneRepository->findOrFail($id);

        try {
            Event::dispatch('shipping.shipping_zone.delete.before', $id);

            $this->shippingZoneRepository->delete($id);

            Event::dispatch('shipping.shipping_zone.delete.after', $id);

            return new JsonResponse([
                'message' => trans('admin::app.settings.shipping-zones.delete-success'),
            ]);
        } catch (\Exception $e) {
            report($e);
        }

        return new JsonResponse([
            'message' => trans('admin::app.settings.shipping-zones.delete-failed'),
        ], 500);
    }

    /**
     * Build the zone attributes from the request.
     */
    protected function prepareData(ShippingZoneRequest $request): array
    {
        return [
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'base_cost' => $request->input('base_cost') ?: 0,
            'free_qty' => $request->input('free_qty') ?: 0,
            'extra_unit_cost' => $request->input('extra_unit_cost') ?: 0,
            'provinces' => $request->input('provinces', []),
            'is_fallback' => $request->input('is_fallback') ? 1 : 0,
            'status' => $request->input('status') ? 1 : 0,
        ];
    }

    /**
     * Ensure only one zone is flagged as the fallback.
     */
    protected function syncFallback($zone): void
    {
        if (! $zone->is_fallback) {
            return;
        }

        $this->shippingZoneRepository
            ->getModel()
            ->newQuery()
            ->where('id', '!=', $zone->id)
            ->update(['is_fallback' => 0]);
    }

    /**
     * Get the South African provinces for the zone assignment UI.
     */
    protected function getProvinces()
    {
        return $this->countryStateRepository
            ->where('country_code', 'ZA')
            ->orderBy('default_name')
            ->get(['code', 'default_name']);
    }
}
