<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLiveShareServicesApprovedToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('share_approved');
            $table->dropColumn('live_approved');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('share_approved')->nullable();
            $table->integer('live_approved')->nullable();
            $table->integer('services_approved')->nullable();
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
