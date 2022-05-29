<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('auctioninfoid');
            $table->foreign('auctioninfoid')->references('id')->on('auction_infos');
            $table->string('fileaddress');
            $table->boolean('sideflag'); // 1 : seller, 2 : buyer
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
        Schema::dropIfExists('auction_documents');
    }
}
