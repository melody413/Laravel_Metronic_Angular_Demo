<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qanswers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255)->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('module_name', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('qanswer_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('qanswer_id')->unsigned();
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['qanswer_id', 'locale']);
            $table->foreign('qanswer_id')->references('id')->on('qanswers')->onDelete('cascade');
        });

        Schema::create('qanswer_specialty', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('qanswer_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->unique(['qanswer_id', 'specialty_id']);
            $table->foreign('qanswer_id')->references('id')->on('qanswers')->onDelete('cascade');
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
        Schema::dropIfExists('qanswer_specialty');
        Schema::dropIfExists('qanswer_trans');
        Schema::dropIfExists('qanswers');
    }
}
