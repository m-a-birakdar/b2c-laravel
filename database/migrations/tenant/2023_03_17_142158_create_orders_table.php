<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Order\Enums\OrderStatusEnum;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->unique();
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('status')->default(OrderStatusEnum::Pending->value);
//            $table->tinyInteger('payment_method'); // Todo
            $table->integer('items_count');
            $table->integer('items_qty');
            $table->decimal('shipping_amount')->nullable();
            $table->decimal('tax_amount')->nullable();
            $table->decimal('items_amount');
            $table->decimal('discount_amount')->nullable();
            $table->decimal('total_amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
