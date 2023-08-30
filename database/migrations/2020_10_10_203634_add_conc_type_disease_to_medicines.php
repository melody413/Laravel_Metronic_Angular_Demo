<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConcTypeDiseaseToMedicines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('conc_type', 350)->nullable();
            $table->string('disease_ar', 250)->nullable();
            $table->string('disease_2', 250)->nullable();
            $table->string('disease_2_ar', 250)->nullable();
            $table->string('disease_3', 250)->nullable();
            $table->string('disease_3_ar', 250)->nullable();
            $table->string('side_effects_ar', 250)->nullable();
            $table->text('image')->nullable();
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
