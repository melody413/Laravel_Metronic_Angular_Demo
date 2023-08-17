<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneAddressSocialToMedicinesCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicines_companies', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('area_id')->unsigned()->nullable();
            $table->string('phone', 255)->nullable();
            $table->text('image')->nullable();
            $table->string('facebook', 350)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('instagram', 250)->nullable();
            $table->string('youtube', 250)->nullable();
            $table->string('website', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            //
        });
    }
}
