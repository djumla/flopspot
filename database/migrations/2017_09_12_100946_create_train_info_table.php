<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_info', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('station_name')->unsigned();
            $table->integer('destination')->unsigned();
            $table->integer('train_number')->unsigned();
            $table->integer('train_type')->unsigned();
            $table->integer('train_name')->unsigned();
            $table->timestamps();
        });

        Schema::table('train_info', function($table) {
          $table->foreign('station_name')->references('id')->on('train_station')->onDelete('cascade');
          $table->foreign('destination')->references('id')->on('train_destination')->onDelete('cascade');
          $table->foreign('train_number')->references('id')->on('train_number')->onDelete('cascade');
          $table->foreign('train_type')->references('id')->on('train_type')->onDelete('cascade');
          $table->foreign('train_name')->references('id')->on('train_name')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('train_info');
    }
}
