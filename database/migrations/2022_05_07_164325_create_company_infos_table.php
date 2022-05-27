<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->string('companyname');
            $table->string('autogroupname');
            $table->string('businessnumber');
            $table->string('dealercode');
            $table->string('mechanicallevel');
            $table->string('website');
            $table->string('fax');
            $table->string('about');
            $table->string('cpfirstname');
            $table->string('cplastname');
            $table->string('cpmobile');
            $table->string('cpemail');
            $table->string('cpposition');
            $table->string('cppicture');
            $table->string('logo');
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
        Schema::dropIfExists('company_infos');
    }
}
