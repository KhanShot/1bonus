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
        Schema::create('institution_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("institution_id")->nullable();
            $table->foreign('institution_id')->references('id')
                ->on('institutions')->cascadeOnDelete();
            $table->tinyInteger("dayNumber");
            $table->string("day");
            $table->string("open")->nullable();
            $table->string("close")->nullable();
            $table->boolean("dayOff");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution_schedules');
    }
};
