<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('category', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('disease', 255)->nullable();
            $table->string('trade_name', 350)->nullable();
            $table->integer('concentration')->unsigned()->nullable();
            $table->string('form', 250)->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            $table->integer('price')->unsigned()->nullable();
            $table->string('dose', 250)->nullable();
            $table->string('company', 250)->nullable();
            $table->string('scientific_name_1', 250)->nullable();
            $table->string('scientific_name_2', 250)->nullable();
            $table->string('scientific_name_3', 250)->nullable();
            $table->string('made_in', 250)->nullable();
            $table->string('side_effects', 250)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('medicine_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('medicine_id')->unsigned();
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['medicine_id', 'locale']);
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_trans');
        Schema::dropIfExists('medicines');
    }
}
