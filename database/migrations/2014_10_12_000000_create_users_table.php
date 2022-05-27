<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('mobile');
            $table->integer('countryid');
            $table->foreign('countryid')->references('id')->on('countries');
            $table->integer('provinceid');
            $table->foreign('provinceid')->references('id')->on('provinces');
            $table->integer('cityid');
            $table->foreign('cityid')->references('id')->on('cities');
            $table->string('address');
            $table->string('zipcode');
            $table->string('profilepicture');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('category');//1 = company, 2 = private
            $table->integer('subcategory');//1 = ins, 2 = deal, 3 = tran
            $table->integer('class')->default(0);//0 : normal, 1 : vip
            $table->date('birthdate');
            $table->boolean("status")->default(1);
            $table->boolean("emailconfirmed")->default(0);
            $table->boolean("phoneconfirmed")->default(0);
            $table->string('wallet')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
