<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_types', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('hospital_type_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('hospital_type_id')->unsigned();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['hospital_type_id', 'locale']);
            $table->foreign('hospital_type_id')->references('id')->on('hospital_types')->onDelete('cascade');
        });


        Schema::create('hospital_hospital_type', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('hospital_id')->unsigned();
            $table->integer('hospital_type_id')->unsigned();
            $table->unique(['hospital_id', 'hospital_type_id']);
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('hospital_type_id')->references('id')->on('hospital_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_type_trans');
        Schema::dropIfExists('hospital_types');
    }
}
