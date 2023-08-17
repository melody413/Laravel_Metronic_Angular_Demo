<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('name', 350)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('medicines_company_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('medicines_company_id')->unsigned();
            $table->string('name', 255);
            $table->string('locale', 2);
            $table->unique(['medicines_company_id', 'locale']);
            $table->foreign('medicines_company_id')->references('id')->on('medicines_companies')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines_company_trans');
        Schema::dropIfExists('medicines_companies');
    }
}
