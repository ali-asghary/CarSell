<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionClaimInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_claim_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('auctionid');
            $table->foreign('auctionid')->references('id')->on('auction_infos');
            $table->string('investigationtime')->default(259200000);
            $table->string('claimdealclearingtime')->default(172800000);
            $table->string('carpagertime')->default(86400000);
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
        Schema::dropIfExists('auction_claim_infos');
    }
}
