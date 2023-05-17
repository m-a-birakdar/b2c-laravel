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
            ->editColumn('name', function(Product $product) {
                return '<div class="d-flex mx-8">
                            <a href="' . route('admin.products.show', ['id' => $product->id]) . '" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . $product->avatar .');"></span></a>
                            <div class="ms-5 d-flex align-items-start flex-column">
                                <a href="' . route('admin.products.show', ['id' => $product->id]) . '" class="text-gray-800 text-hover-primary fs-5 fw-bolder" style="margin-bottom: 0.5rem" data-kt-ecommerce-product-filter="product_name">' . $product->name . '</a>
                                <div class="text-muted fs-7 fw-bolder align-items-start">
                                    <span class="text-muted fs-7 fw-bolder">' . tr("id") . ': ' . $product->sku .'</span><span class="mx-2">|</span><a href="' . route('admin.suppliers.show', ['id' => $product->supplier_id]) .'"><span>' . $product->supplier->company_name .'</span></a>
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['name', 'status'])
            ;
    }

    public function query(Product $model)
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
            Column::make('name')->title(tr('name')),
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
