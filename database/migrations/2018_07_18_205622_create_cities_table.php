<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->index();;
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });



        Schema::create('city_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('city_id')->unsigned();
            $table->string('name', 255);
            $table->string('locale', 2);
            $table->unique(['city_id', 'locale']);

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_trans');
        Schema::dropIfExists('cities');
    }
}
