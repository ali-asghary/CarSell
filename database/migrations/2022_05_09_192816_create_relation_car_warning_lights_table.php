<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationCarWarningLightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_car_warning_lights', function (Blueprint $table) {
            $table->id();
            $table->integer('carid');
            $table->foreign('carid')->references('id')->on('cars');
            $table->integer('warninglightid');
            $table->foreign('warninglightid')->references('id')->on('car_warning_lights');
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
        Schema::dropIfExists('relation_car_warning_lights');
    }
}
