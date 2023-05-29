<?php

namespace App\DataTables;


use Yajra\DataTables\Html\Button;

class DataTableDefault
{
    public static function buttons(): array
    {
        return [
            Button::make('print')->text('<i class="la la-print mr-05"></i> ' . tr('print'))->addClass('btn btn-sm btn-danger box-shadow-05'),
            Button::make('export')->text('<i class="la la-upload mr-05" ></i> ' . tr('export'))->buttons(['csv' , 'excel'])->addClass('btn btn-sm btn-success box-shadow-05'),
            Button::make('reload')->text('<i class="la la-refresh mr-05" ></i> ' . tr('refresh'))->addClass('btn btn-sm btn-warning box-shadow-05'),
        ];
    }

    public static function parameters(): array
    {
        return [
//            'language' => ['url' => url('/vendor/datatables/'.config('app.locale').'.json'),],
            'dom' => '<"top d-flex justify-content-between align-item-center"<"d-flex"B><<"btn btn-secondary btn-sm mx-2"i>>><"table-responsive"tr><"d-flex justify-content-between"<"d-flex"l><"d-flex"p>>',
            'initComplete' => "function () {
                                this.api().columns().every(function () {
                                    var column = this;
                                    var input = document.createElement(\"input\");
                                    $(input).appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                                });
                              }",
        ];
    }

    public static function parametersWithoutResponsive(): array
    {
        return [
            'language' => ['url' => url('/vendor/datatables/'.config('app.locale').'.json'),],
            'dom' => '<"top"<"float-left"B><"float-right"l><"float-right btn btn-secondary btn-sm mx-2"i>><tr><"row justify-content-center"p><"clear">',
            'initComplete' => "function () {
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement(\"input\");
                                $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
        ];
    }
}
