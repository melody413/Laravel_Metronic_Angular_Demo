<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('activeIngredient')->nullable();
            $table->string('maximumIntake')->nullable();
            $table->string('strengthUnit')->nullable();
            $table->string('doseUnit')->nullable();
            $table->string('frequency')->nullable();
            $table->string('targetPopulation')->nullable();
            $table->string('max_doseUnit')->nullable();
            $table->string('max_doseValue')->nullable();
            $table->string('max_frequency')->nullable();
            $table->string('max_targetPopulation')->nullable();
        });

        Schema::table('medicine_trans', function (Blueprint $table) {
            $table->string('breastfeedingWarning')->nullable();
            $table->string('clinicalPharmacology')->nullable();
            $table->string('foodWarning')->nullable();
            $table->string('mechanismOfAction')->nullable();
            $table->string('overdosage')->nullable();
            $table->string('pregnancyWarning')->nullable();
            $table->string('prescriptionStatus')->nullable();
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
