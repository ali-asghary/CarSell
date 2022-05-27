<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_users', function (Blueprint $table) {
            $table->id();
            $table->integer('auctionid');
            $table->foreign('auctionid')->references('id')->on('auction_infos');
            $table->integer('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->integer('pay_type');// 1 : vip user, 2 : payment, 3 : carpage
            $table->boolean('auto_bid')->default(0);
            $table->string('maxbid');
            $table->string('auto_bid_value');
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
        Schema::dropIfExists('auction_users');
    }
}
