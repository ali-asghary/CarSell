<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->boolean('discounttype');
            $table->string('discount');
            $table->integer('make');
            $table->foreign('make')->references('id')->on('car_makes');
            $table->integer('model');
            $table->foreign('model')->references('id')->on('car_models');
            $table->string('year');
            $table->string('mileage'); // karkard mashin
            $table->string('color');
            $table->integer('bodytypeid');
            $table->foreign('bodytypeid')->references('id')->on('car_body_types');
            $table->integer('drivetrain');
            $table->foreign('drivetrain')->references('id')->on('car_drive_trains');
            $table->integer('transmission');
            $table->foreign('transmission')->references('id')->on('car_transmissions');
            $table->integer('fueltypeid');
            $table->foreign('fueltypeid')->references('id')->on('car_fuel_types');
            $table->integer('enginetypeid');
            $table->foreign('enginetypeid')->references('id')->on('car_engine_types');
            $table->integer('condition');
            $table->foreign('condition')->references('id')->on('car_conditions');
            $table->integer('accident');
            $table->foreign('accident')->references('id')->on('car_accidents');
            $table->integer('door');
            $table->string('vinnumber');
            $table->text('description');
            $table->boolean('auction');// 0 = normal sell, 1 = auction sell
            $table->integer('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('cars');
    }
}
