<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->longText('fcm_token')->nullable();
            $table->longText('device_info')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
