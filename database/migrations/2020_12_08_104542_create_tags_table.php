<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255)->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('module_name', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('tag_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->string('description', 255)->nullable();
            $table->string('locale', 2);
            $table->unique(['tag_id', 'locale']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });

        Schema::create('specialty_tag', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->unique(['tag_id', 'specialty_id']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('tag_trans');
        Schema::dropIfExists('specialty_tag');
        Schema::dropIfExists('tags');
    }
}
