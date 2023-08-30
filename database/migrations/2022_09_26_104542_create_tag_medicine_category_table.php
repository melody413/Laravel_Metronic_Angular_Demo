<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagMedicineCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_medicine_category', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('medicines_category_id')->unsigned();
            // $table->unique(['tag_id', 'medicines_category_id']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('medicines_category_id')->references('id')->on('medicines_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_medicine_category');
    }
}
