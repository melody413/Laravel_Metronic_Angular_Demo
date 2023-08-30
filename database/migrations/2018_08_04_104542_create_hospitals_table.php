<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255)->nullable();
            $table->string('lat_lng', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('area_id')->unsigned()->nullable();
            $table->text('image_gallery')->nullable();
            $table->text('shortcuts')->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('labs')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });

        Schema::create('hospital_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('hospital_id')->unsigned();
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('locale', 2);
            $table->unique(['hospital_id', 'locale']);
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });

        Schema::create('hospital_specialty', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('hospital_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->unique(['hospital_id', 'specialty_id']);
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_specialty');
        Schema::dropIfExists('hospital_trans');
        Schema::dropIfExists('hospitals');
    }
}
