<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('city_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->string('title')->index();
            $table->string('sku')->unique();
            $table->boolean('status')->default(true);
            $table->string('thumbnail');
            $table->decimal('price');
            $table->decimal('discount')->nullable();
            $table->integer('rank')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
