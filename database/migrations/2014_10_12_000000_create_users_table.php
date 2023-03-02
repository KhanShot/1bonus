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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->unsignedBigInteger("city_id")->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('socialite')->nullable();
            $table->string('socialite_id')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('married')->nullable();
            $table->string('type')->nullable()->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
