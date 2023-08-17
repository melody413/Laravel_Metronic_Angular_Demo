<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionLeftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_lefts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id');
            $table->text('cc')->nullable();
            $table->text('oe')->nullable();
            $table->text('pd')->nullable();
            $table->text('dd')->nullable();
            $table->text('lab_workup')->nullable();
            $table->text('advice')->nullable();
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
        Schema::dropIfExists('prescription_lefts');
    }
}
