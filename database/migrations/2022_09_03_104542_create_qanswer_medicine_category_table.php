<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQanswerMedicineCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qanswer_medicine_category', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('qanswer_id')->unsigned();
            $table->integer('medicines_category_id')->unsigned();
            // $table->unique(['qanswer_id', 'medicines_category_id']);
            $table->foreign('qanswer_id')->references('id')->on('qanswers')->onDelete('cascade');
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
        Schema::dropIfExists('qanswer_medicine_category');
    }
}
