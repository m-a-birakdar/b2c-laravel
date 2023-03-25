<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Invoice\Database\factories\InvoiceFactory
    {
        return \Modules\Invoice\Database\factories\InvoiceFactory::new();
    }
}
