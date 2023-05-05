<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('status', 20)->default(\Modules\City\Enums\StatusEnum::Unavailable->value)->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
