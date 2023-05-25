<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupon_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('coupon_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('times_used');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
