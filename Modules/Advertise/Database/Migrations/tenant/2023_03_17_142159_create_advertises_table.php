<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('advertises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('url');
            $table->string('type', 10);
            $table->integer('rank')->nullable();
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->tinyInteger('redirect_in')->default(false);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advertises');
    }
};
