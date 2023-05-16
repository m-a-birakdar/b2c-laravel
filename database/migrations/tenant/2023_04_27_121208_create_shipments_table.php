<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Shipment\Enums\ShipmentStatusEnum;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('track_number')->unique();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('courier_id')->constrained('users');
            $table->tinyInteger('status')->default(ShipmentStatusEnum::NotYetShipped->value);
            $table->foreignId('address_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
