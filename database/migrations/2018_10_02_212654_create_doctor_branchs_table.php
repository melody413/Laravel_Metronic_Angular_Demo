<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorBranchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_branches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned();
            $table->string('day_of_week', 10);
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('patient_every');
            $table->float('price')->nullable();
            $table->integer('phones')->nullable();
            $table->string('lat_lng', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('doctor_branch_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_branch_id')->unsigned();
            $table->text('address')->nullable();
            $table->string('locale', 2);
            $table->unique(['doctor_branch_id', 'locale']);
            $table->foreign('doctor_branch_id')->references('id')->on('doctor_branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_branch_trans');
        Schema::dropIfExists('doctor_branches');
    }
}
