<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabPharmacyCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacy_companies', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('country_id')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('pharmacy_company_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('pharmacy_company_id');
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['pharmacy_company_id', 'locale']);
            // $table->foreign('pharmacy_company_id')->constrained()->onDelete('restrict');
        });

        Schema::create('lab_companies', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('country_id')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('lab_company_trans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('lab_company_id');
            $table->string('name', 255);
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 2);
            $table->unique(['lab_company_id', 'locale']);
            // $table->foreign('lab_company_id')->constrained()->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacy_company_trans');
        Schema::dropIfExists('pharmacy_companies');
        Schema::dropIfExists('lab_company_trans');
        Schema::dropIfExists('lab_companies');
    }
}
