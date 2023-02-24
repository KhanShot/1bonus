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
        Schema::create('institution_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("institution_id");
            $table->foreign('institution_id')->references('id')
                ->on('institutions')->cascadeOnDelete();
            $table->string('phone')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution_phones');
    }
};
