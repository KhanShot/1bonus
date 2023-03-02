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
        Schema::table('institution_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger("city_id")->after('institution_id')->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institution_addresses', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
};
