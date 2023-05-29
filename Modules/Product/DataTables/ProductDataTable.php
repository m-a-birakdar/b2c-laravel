<?php

namespace Modules\Product\DataTables;

use App\DataTables\DataTableDefault;
use Modules\Product\Entities\Product;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    public function dataTable($query): \Yajra\DataTables\EloquentDataTable
    {
        $columns = $this->request()->get('columns');
        return datatables()->eloquent($query)->smart(true)
            ->filter(function ($query) use ($columns) {
                if(!empty($columns[2]['search']['value']))
                    $query->whereHas('subCategory', function ($q) use ($columns) {
                        $q->where('name', 'Like', '%' . $columns[2]['search']['value'] . '%');
                    });
                if(!empty($columns[1]['search']['value']))
                    $query->whereHas('subCategory.category', function ($q) use ($columns) {
                        $q->where('name', 'Like', '%' . $columns[1]['search']['value'] . '%');
                    });
            })
            ->rawColumns(['name', 'status'])
            ;
    }

    public function query(Product $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->newQuery();
    }

    public function html(): Builder
    {
        $buttons = array_merge(
            [Button::make('create')->text('<i class="la la-plus mr-05"></i> ' . tr('create'))->addClass('btn btn-sm btn-info box-shadow-05')->action("window.location = '".route('products.create')."';"),],
            DataTableDefault::buttons()
        );
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters(DataTableDefault::parameters())
            ->buttons($buttons)
            ;
    }

    protected function getColumns(): array
    {
        return [
            Column::make('title')->title(tr('title')),
//            Column::make('sub_category.category.name')->title(tr('main_category'))->name('sub_category.category.name')->searchable(false)->orderable(false),
//            Column::make('sub_category.name')->title(tr('sub_category'))->name('sub_category.name')->searchable(false)->orderable(false),
//            Column::make('supplier.name')->title(tr('supplier'))->name('supplier.name'),
            Column::make('price')->title(tr('price')),
//            Column::make('quantity')->title(tr('quantity')),
        ];
    }

    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
