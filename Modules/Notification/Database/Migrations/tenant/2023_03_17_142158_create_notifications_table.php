<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
//        Schema::create('notifications', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->foreignId('user_id')->constrained();
//            $table->string('title');
//            $table->string('body');
//            $table->tinyInteger('type')->index();
//            $table->string('initial')->nullable();
//            $table->integer('clicks')->default(0);
//            $table->timestamp('read_at')->nullable()->index();
//            $table->timestamps();
//        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
