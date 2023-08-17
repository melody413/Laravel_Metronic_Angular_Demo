<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMapLinkInHospitalsCentersLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->string('map_link', 255)->nullable();

        });
        Schema::table('centers', function (Blueprint $table) {
            $table->string('map_link', 255)->nullable();

        });
        Schema::table('labs', function (Blueprint $table) {
            $table->string('map_link', 255)->nullable();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
