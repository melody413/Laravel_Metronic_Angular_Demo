<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diseases', function (Blueprint $table) {
        });

        Schema::table('disease_trans', function (Blueprint $table) {
            $table->string('risk_factors')->nullable();
            $table->string('lifestyle_home_remedies')->nullable();
            $table->string('preparing_appointment')->nullable();
            $table->string('infectious_disease_infectiousAgent')->nullable();
            $table->string('infectious_disease_infectiousAgentClassBacteria')->nullable();
            $table->string('infectious_disease_infectiousAgentClassFungus')->nullable();
            $table->string('infectious_disease_infectiousAgentClassMulticellularParasite')->nullable();
            $table->string('infectious_disease_infectiousAgentClassPrion')->nullable();
            $table->string('infectious_disease_infectiousAgentClassProtozoa')->nullable();
            $table->string('infectious_disease_infectiousAgentClassVirus')->nullable();
            $table->string('infectious_disease_transmissionMethod')->nullable();
            $table->string('associatedDisease')->nullable();
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
