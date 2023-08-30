<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToHospitalsCentersPharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable();
        });
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable();
        });
        Schema::table('centers', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals_centers_pharmacies', function (Blueprint $table) {
            //
        });
    }
}
