<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVipInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vip_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->date('startdate');
            $table->date('expiredate');
            $table->string('pad');
            $table->integer('billing');// 1 : weekly, 2 : bi weekly, 3 : monthly
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
        Schema::dropIfExists('user_vip_infos');
    }
}
