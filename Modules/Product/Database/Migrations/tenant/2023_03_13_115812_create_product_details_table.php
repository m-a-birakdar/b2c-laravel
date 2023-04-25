<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->constrained();
            $table->longText('description');
            $table->integer('quantity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_details');
    }
};
