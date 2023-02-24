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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("institution_id")->nullable();
            $table->foreign('institution_id')->references('id')
                ->on('institutions')->cascadeOnDelete();

            $table->unsignedBigInteger("service_category_id")->nullable();
            $table->foreign('service_category_id')->references('id')
                ->on('service_categories')->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->float('price', 12,2 )->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
