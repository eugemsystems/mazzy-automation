<?php

namespace Webkul\Admin\DataGrids\Settings;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class CollectionPointsDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('collection_points')
            ->select(
                'id',
                'code',
                'name',
                'state',
                'city',
                'handling_fee',
                'status'
            );
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'city',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.city'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'state',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.state'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'handling_fee',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.handling-fee'),
            'type' => 'string',
            'sortable' => true,
            'closure' => function ($row) {
                return core()->formatBasePrice($row->handling_fee);
            },
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.settings.collection-points.index.datagrid.status'),
            'type' => 'boolean',
            'filterable' => true,
            'filterable_options' => [
                [
                    'label' => trans('admin::app.settings.collection-points.index.datagrid.active'),
                    'value' => 1,
                ],
                [
                    'label' => trans('admin::app.settings.collection-points.index.datagrid.inactive'),
                    'value' => 0,
                ],
            ],
            'sortable' => true,
            'closure' => function ($row) {
                if ($row->status) {
                    return trans('admin::app.settings.collection-points.index.datagrid.active');
                }

                return trans('admin::app.settings.collection-points.index.datagrid.inactive');
            },
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('settings.collection_points.edit')) {
            $this->addAction([
                'icon' => 'icon-edit',
                'title' => trans('admin::app.settings.collection-points.index.datagrid.edit'),
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.collection_points.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('settings.collection_points.delete')) {
            $this->addAction([
                'icon' => 'icon-delete',
                'title' => trans('admin::app.settings.collection-points.index.datagrid.delete'),
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.collection_points.delete', $row->id);
                },
            ]);
        }
    }
}
