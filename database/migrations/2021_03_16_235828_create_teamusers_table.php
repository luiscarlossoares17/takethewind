<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teamusers', function (Blueprint $table) {
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('companyuser_id')->unsigned();
            $table->bigInteger('userlevel_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('companyuser_id')->references('id')->on('companyusers');
            $table->foreign('userlevel_id')->references('id')->on('userlevels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teamusers');
    }
}
