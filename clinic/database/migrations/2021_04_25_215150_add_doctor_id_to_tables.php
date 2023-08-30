<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDoctorIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //prescriptions
        // Schema::create('prescriptions', function (Blueprint $table) {
        //     $table->integer('doctor_id');
        // });
        // //patients
        // Schema::create('patients', function (Blueprint $table) {
        //     $table->integer('doctor_id');
        // });
        // //appointments
        // Schema::create('appointments', function (Blueprint $table) {
        //     $table->integer('doctor_id');
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
