<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->string('code');
            $table->date('expiredate');
            $table->string('expiretime');
            $table->boolean('confirmtype'); // 0 = email , 1 = phone
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
        Schema::dropIfExists('confirm_codes');
    }
}
