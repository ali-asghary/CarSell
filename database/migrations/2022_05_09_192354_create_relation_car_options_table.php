<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationCarOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_car_options', function (Blueprint $table) {
            $table->id();
            $table->integer('carid');
            $table->foreign('carid')->references('id')->on('cars');
            $table->integer('optionid');
            $table->foreign('optionid')->references('id')->on('car_options');
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
        Schema::dropIfExists('relation_car_options');
    }
}
