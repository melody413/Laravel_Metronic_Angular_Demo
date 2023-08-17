<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSymptomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('country_id')->nullable();
            $table->string('body_parts_ids')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('symptom_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('symptom_id');
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['symptom_id', 'locale']);
            // $table->foreign('symptom_id')->references('id')->on('symptoms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('symptom_trans');
        Schema::dropIfExists('symptoms');
    }
}
