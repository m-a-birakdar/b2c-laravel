<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Whatsapp\Enums\StatusEnum;
use Modules\Whatsapp\Enums\TypeEnum;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->default(TypeEnum::TEXT->value);
            $table->string('priority')->index();
            $table->string('phone');
            $table->longText('message');
            $table->longText('media')->nullable();
            $table->string('status')->default(StatusEnum::PENDING->value)->index();
            $table->timestamp('send_at')->index()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp');
    }
};
