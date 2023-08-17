<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('specialty_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('specialty_id')->unsigned();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['specialty_id', 'locale']);
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
        Schema::dropIfExists('specialty_trans');
        Schema::dropIfExists('specialties');
    }
}
