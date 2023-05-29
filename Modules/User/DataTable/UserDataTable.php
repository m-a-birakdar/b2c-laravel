<?php

namespace Modules\User\DataTable;

use App\DataTables\DataTableDefault;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\User\Entities\User;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'category.action')
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $buttons = array_merge(
            [
                Button::make('create')->text('<i class="la la-plus mr-05"></i> Add')->addClass('btn btn-sm btn-info box-shadow-05')->action("window.location = '" . route('users.create') . "';"),
//                Button::make('create')->text('<i class="la la-download mr-05"></i> Import')->addClass('btn btn-sm btn-primary box-shadow-05')->action("window.location = '" . route('groups.get-import') . "';"),
            ],
            DataTableDefault::buttons()
        );
        return $this->builder()->pageLength(25)->setTableId('categories-table')->columns($this->getColumns())->minifiedAjax()
            ->parameters(DataTableDefault::parameters())->selectStyleSingle()->buttons($buttons);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
        ];
    }

    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
