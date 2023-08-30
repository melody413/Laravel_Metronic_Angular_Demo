<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionTemplateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_template_drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_template_id');
            $table->integer('drug_id');
            $table->string('type')->nullable();
            $table->string('dose')->nullable();
            $table->string('duration')->nullable();
            $table->string('strength')->nullable();
            $table->string('advice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_template_drugs');
    }
}
