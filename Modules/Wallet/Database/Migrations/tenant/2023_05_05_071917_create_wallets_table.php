<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique()->index();
            $table->foreignId('user_id')->constrained();
            $table->decimal('balance');
            $table->boolean('status')->default(true)->index();
            $table->boolean('allow_send')->default(true);
            $table->boolean('allow_receive')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
};
