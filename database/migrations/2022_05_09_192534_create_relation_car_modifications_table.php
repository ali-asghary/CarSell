<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationCarModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_car_modifications', function (Blueprint $table) {
            $table->id();
            $table->integer('carid');
            $table->foreign('carid')->references('id')->on('cars');
            $table->integer('modificationid');
            $table->foreign('modificationid')->references('id')->on('car_modifications');
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
        Schema::dropIfExists('relation_car_modifications');
    }
}
