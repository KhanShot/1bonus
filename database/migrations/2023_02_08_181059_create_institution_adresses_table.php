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
        Schema::create('institution_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("institution_id");
            $table->foreign('institution_id')->references('id')
                ->on('institutions')->cascadeOnDelete();
            $table->unsignedBigInteger("city_id")->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')->cascadeOnDelete();
            $table->string("full_address");
            $table->string("city");
            $table->string("long");
            $table->string("lat");
            $table->string("premiseNumber");
            $table->string("street");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution_addresses');
    }
};
