<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('image', 255)->nullable();
            $table->string('lat_lng', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('area_id')->unsigned()->nullable();
            $table->text('shortcuts')->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('labs')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });

        Schema::create('lab_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lab_id')->unsigned();
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('locale', 2);
            $table->unique(['lab_id', 'locale']);
            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');
        });

        Schema::create('lab_services', function(Blueprint $table)
        {
            $table->increments('id');
            $table->softDeletes();
            $table->timestamps();

        });

        Schema::create('lab_service_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lab_service_id')->unsigned();
            $table->string('name', 255);
            $table->string('locale', 2);
            $table->unique(['lab_service_id', 'locale']);
            $table->foreign('lab_service_id')->references('id')->on('lab_services')->onDelete('cascade');
        });

        Schema::create('lab_lab_service', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lab_id')->unsigned();
            $table->integer('lab_service_id')->unsigned();
            $table->unique(['lab_id', 'lab_service_id']);
            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');
            $table->foreign('lab_service_id')->references('id')->on('lab_services')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labs_lab_services');
        Schema::dropIfExists('lab_services_trans');
        Schema::dropIfExists('lab_services');
        Schema::dropIfExists('lab_trans');
        Schema::dropIfExists('labs');
    }
}
