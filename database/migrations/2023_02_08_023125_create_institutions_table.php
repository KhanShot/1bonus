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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");

            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();

            $table->unsignedBigInteger("category_id");
            $table->foreign('category_id')->references('id')
                ->on('categories')->cascadeOnDelete();

            $table->string("name");
            $table->string("description")->nullable();
            $table->string("insta")->nullable();
            $table->string("telegram")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("logo")->nullable();
            $table->string("image")->nullable();
            $table->string("bg_image")->nullable();
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
        Schema::dropIfExists('institutions');
    }
};
