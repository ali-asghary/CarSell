<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpgratedUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrated_user_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->date('upgradedate');
            $table->date('upgradeexpire');
            $table->string('pad');
            $table->string('bill');// 1 = weekly, 2 = bi weekly, 3 = monthly
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
        Schema::dropIfExists('upgrated_user_infos');
    }
}
