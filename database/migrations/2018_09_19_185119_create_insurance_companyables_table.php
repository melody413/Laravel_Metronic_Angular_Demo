<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceCompanyablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_companyables', function (Blueprint $table) {
            $table->increments('id');

            $table->string("insurance_companyable_type")->nullable();
            $table->integer("insurance_companyable_id")->nullable();
            $table->integer("insurance_company_id")->nullable();

            //$table->unique(['icable_id', 'insurance_company_id','icable_type']);

            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_companyables');
    }
}
