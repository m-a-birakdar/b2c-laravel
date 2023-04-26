<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->boolean('status')->default(true);
            $table->string('image');
            $table->integer('rank')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
