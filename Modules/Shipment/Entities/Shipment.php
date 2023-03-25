<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Shipment\Database\factories\ShipmentFactory
    {
        return \Modules\Shipment\Database\factories\ShipmentFactory::new();
    }
}
