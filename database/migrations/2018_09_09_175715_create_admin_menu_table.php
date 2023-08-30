<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon',255)->default('view_list');
            $table->string('title',255);
            $table->string('url',255)->nullable();
            $table->boolean('in_menu')->default('1');
            $table->boolean('in_permission')->default('1');
            $table->boolean('has_sub')->default('1');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('display_order')->default('0');
            $table->string('controller', 255)->nullable();
            $table->string('action', 255)->nullable();
            $table->string('params', 255)->nullable();
            $table->string('route_name', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('admin_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menus');
    }
}
