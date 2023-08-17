<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rate');
            $table->text('comment');
            $table->tinyInteger('is_active');
            $table->integer('doctor_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_rating');
    }
}
