<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 100)->unique();
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('faq_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('faq_id')->unsigned();
            $table->string('title', 255);
            $table->text('content');
            $table->text('meta_title');
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->string('locale', 2);
            $table->unique(['faq_id', 'locale']);
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('faq_trans');
        Schema::drop('faqs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
