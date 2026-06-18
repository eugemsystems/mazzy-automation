<?php

namespace Webkul\Admin\DataGrids\Settings;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ShippingClassesDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('shipping_classes')
            ->select('id', 'code', 'name', 'status');
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
            'label' => trans('admin::app.settings.shipping-classes.index.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('admin::app.settings.shipping-classes.index.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.settings.shipping-classes.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.settings.shipping-classes.index.datagrid.status'),
            'type' => 'boolean',
            'filterable' => true,
            'filterable_options' => [
                [
                    'label' => trans('admin::app.settings.shipping-classes.index.datagrid.active'),
                    'value' => 1,
                ],
                [
                    'label' => trans('admin::app.settings.shipping-classes.index.datagrid.inactive'),
                    'value' => 0,
                ],
            ],
            'sortable' => true,
            'closure' => function ($row) {
                if ($row->status) {
                    return trans('admin::app.settings.shipping-classes.index.datagrid.active');
                }

                return trans('admin::app.settings.shipping-classes.index.datagrid.inactive');
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
        if (bouncer()->hasPermission('settings.shipping_classes.edit')) {
            $this->addAction([
                'icon' => 'icon-edit',
                'title' => trans('admin::app.settings.shipping-classes.index.datagrid.edit'),
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.shipping_classes.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('settings.shipping_classes.delete')) {
            $this->addAction([
                'icon' => 'icon-delete',
                'title' => trans('admin::app.settings.shipping-classes.index.datagrid.delete'),
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.shipping_classes.delete', $row->id);
                },
            ]);
        }
    }
}
