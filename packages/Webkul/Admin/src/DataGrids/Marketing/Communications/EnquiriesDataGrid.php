<?php

namespace Webkul\Admin\DataGrids\Marketing\Communications;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class EnquiriesDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        return DB::table('form_submissions')
            ->select(
                'form_submissions.id',
                'form_submissions.type',
                'form_submissions.name',
                'form_submissions.email',
                'form_submissions.phone',
                'form_submissions.subject',
                'form_submissions.message',
                'form_submissions.created_at',
            );
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => '#',
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'type',
            'label'      => 'Type',
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => 'Name',
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => 'Email',
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => 'Phone',
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'subject',
            'label'      => 'Subject',
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'message',
            'label'      => 'Message',
            'type'       => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => 'Submitted At',
            'type'       => 'datetime',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('marketing.communications.enquiries.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => 'Delete',
                'method' => 'DELETE',
                'url'    => function ($row) {
                    return route('admin.marketing.communications.enquiries.delete', $row->id);
                },
            ]);
        }
    }
}
