<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_codes', function (Blueprint $table) {
            $table->id();
            $table->string("code")->nullable();
            $table->string("service_sms_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users');
            $table->string("type")->nullable();
            $table->string("phone")->nullable();
            $table->string("status")->nullable();
            $table->string("reason")->nullable();
            $table->boolean("verified")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_codes');
    }
};
