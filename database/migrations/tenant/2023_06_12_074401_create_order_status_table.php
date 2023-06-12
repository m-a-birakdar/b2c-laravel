<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Order\Enums\OrderStatusEnum;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('status');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status');
    }
};
