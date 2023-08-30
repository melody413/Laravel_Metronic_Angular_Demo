<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOthersLabServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_services', function(Blueprint $table)
        {
            $table->string('image', 255)->nullable();
        });

        Schema::table('lab_service_trans', function (Blueprint $table) {
            $table->string('sample')->nullable();
            $table->string('measruing_unit')->nullable();
            $table->string('normal_range')->nullable();
            $table->string('about_test')->nullable();
            $table->string('used_to')->nullable();
            $table->string('reasons_for')->nullable();
            $table->string('how_is')->nullable();
            $table->string('how_prepare')->nullable();
            $table->string('risks')->nullable();
            $table->string('interpretation_result')->nullable();
            $table->string('reasons_high_reading')->nullable();
            $table->string('references')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
