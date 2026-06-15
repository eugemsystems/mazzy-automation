<?php

namespace Webkul\Admin\Http\Controllers\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Settings\CollectionPointsDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\CollectionPointRequest;
use Webkul\Shipping\Repositories\CollectionPointRepository;

class CollectionPointController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CollectionPointRepository $collectionPointRepository) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(CollectionPointsDataGrid::class)->process();
        }

        return view('admin::settings.collection-points.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin::settings.collection-points.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(CollectionPointRequest $request)
    {
        Event::dispatch('shipping.collection_point.create.before');

        $data = $request->only([
            'code',
            'name',
            'description',
            'country',
            'state',
            'city',
            'street',
            'postcode',
            'contact_number',
            'handling_fee',
            'status',
        ]);

        $data['status'] = $request->input('status') ? 1 : 0;

        $collectionPoint = $this->collectionPointRepository->create($data);

        Event::dispatch('shipping.collection_point.create.after', $collectionPoint);

        session()->flash('success', trans('admin::app.settings.collection-points.create-success'));

        return redirect()->route('admin.settings.collection_points.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(int $id)
    {
        $collectionPoint = $this->collectionPointRepository->findOrFail($id);

        return view('admin::settings.collection-points.edit', compact('collectionPoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(CollectionPointRequest $request, int $id)
    {
        Event::dispatch('shipping.collection_point.update.before', $id);

        $data = $request->only([
            'code',
            'name',
            'description',
            'country',
            'state',
            'city',
            'street',
            'postcode',
            'contact_number',
            'handling_fee',
            'status',
        ]);

        $data['status'] = $request->input('status') ? 1 : 0;

        $collectionPoint = $this->collectionPointRepository->update($data, $id);

        Event::dispatch('shipping.collection_point.update.after', $collectionPoint);

        session()->flash('success', trans('admin::app.settings.collection-points.update-success'));

        return redirect()->route('admin.settings.collection_points.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->collectionPointRepository->findOrFail($id);

        try {
            Event::dispatch('shipping.collection_point.delete.before', $id);

            $this->collectionPointRepository->delete($id);

            Event::dispatch('shipping.collection_point.delete.after', $id);

            return new JsonResponse([
                'message' => trans('admin::app.settings.collection-points.delete-success'),
            ]);
        } catch (\Exception $e) {
            report($e);
        }

        return new JsonResponse([
            'message' => trans('admin::app.settings.collection-points.delete-failed'),
        ], 500);
    }
}
