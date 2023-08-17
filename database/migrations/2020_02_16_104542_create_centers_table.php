<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
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
            $table->string('facebook', 350)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('instagram', 250)->nullable();
            $table->string('youtube', 250)->nullable();
            $table->string('website', 250)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('labs')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });

        Schema::create('center_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('center_id')->unsigned();
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('locale', 2);
            $table->unique(['center_id', 'locale']);
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
        });

        Schema::create('center_specialty', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('center_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->unique(['center_id', 'specialty_id']);
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
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
        Schema::dropIfExists('center_specialty');
        Schema::dropIfExists('center_trans');
        Schema::dropIfExists('centers');
    }
}
