<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('jb_title',['professor', 'lecturer','consultant','specialist'])->default('specialist');
            $table->string('image', 255)->nullable();
            $table->enum('gender',['male', 'female'])->default('male');
            $table->string('wait_time')->nullable();
            $table->float('price')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('area_id')->unsigned()->nullable();
            $table->text('phones')->nullable();
            $table->text('rate')->nullable();
            $table->text('rate_cnt')->nullable();
            $table->text('image_gallery')->nullable();
            $table->boolean('is_reserve')->default('0');
            $table->boolean('is_active')->default('1');
            $table->integer('user_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('doctor_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned();
            $table->string('name', 255);
            $table->string('title', 255);
            $table->text('excerpt')->nullable();
            $table->string('description', 255);
            $table->string('locale', 2);
            $table->unique(['doctor_id', 'locale']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });

        Schema::create('doctor_specialty', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->unique(['doctor_id', 'specialty_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
        });

//        Schema::create('doctor_insurance_company', function(Blueprint $table)
//        {
//            $table->increments('id');
//            $table->integer('doctor_id')->unsigned();
//            $table->integer('insurance_company_id')->unsigned();
//            $table->unique(['doctor_id', 'insurance_company_id']);
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
//            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onDelete('cascade');
//        });

        Schema::create('doctor_hospital', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned();
            $table->integer('hospital_id')->unsigned();
            $table->unique(['doctor_id', 'hospital_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
