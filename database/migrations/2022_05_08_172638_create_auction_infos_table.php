<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('carid');
            $table->foreign('carid')->references('id')->on('cars');
            $table->integer('registerprovinceid');
            $table->foreign('registerprovinceid')->references('id')->on('provinces');
            $table->boolean('lien')->default(0); // bedehi darad yana ?
            $table->string('unpaiddebt'); // mizane bedehi
            $table->text('otherdisclusure'); // tozihe moshkelate dg
            $table->date('startdate');
            $table->string('starttime');
            $table->string('starttoclose')->default(86400000);
            $table->string('decisiontime')->default(1800000);
            $table->string('tasktime')->default(259200000);
            $table->string('auctiondealclearingtime')->default(172800000);
            $table->boolean('claim')->default(0);
            $table->string('startprice');
            $table->string('minreservedprice');
            $table->integer('status')->default(0); // 0 : dar hale entezar, 1 : success, 2 : error
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
        Schema::dropIfExists('auction_infos');
    }
}
