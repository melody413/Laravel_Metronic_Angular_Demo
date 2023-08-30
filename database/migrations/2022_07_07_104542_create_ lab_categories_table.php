<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_categories', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('country_id')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('lab_category_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('lab_category_id');
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['lab_category_id', 'locale']);
            // $table->foreign('lab_category_id')->constrained()->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_category_trans');
        Schema::dropIfExists('lab_categories');
    }
}
