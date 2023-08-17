<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255)->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('module_name', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('sub_category_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('sub_category_id')->unsigned();
            $table->string('name', 255);
            $table->string('locale', 2);
            $table->unique(['sub_category_id', 'locale']);
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });

        Schema::create('specialty_sub_category', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('sub_category_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->unique(['sub_category_id', 'specialty_id']);
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
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
        Schema::dropIfExists('sub_category_trans');
        Schema::dropIfExists('specialty_sub_category');
        Schema::dropIfExists('sub_categories');
    }
}
