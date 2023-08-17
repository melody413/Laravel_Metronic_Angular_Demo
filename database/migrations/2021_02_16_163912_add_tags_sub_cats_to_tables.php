<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagsSubCatsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
        Schema::table('hospitals', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
        Schema::table('centers', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
        Schema::table('medicines', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
        Schema::table('labs', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
        Schema::table('insurance_companies', function (Blueprint $table) {
            $table->text('tags_en')->nullable();
            $table->text('tags_ar')->nullable();
            $table->text('sub_cats_en')->nullable();
            $table->text('sub_cats_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
