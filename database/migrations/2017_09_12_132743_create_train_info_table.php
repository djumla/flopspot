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
            $table->integer('station')->unsigned();
            $table->integer('train_name')->unsigned();
            $table->timestamps();
        });

        Schema::table('train_info', function($table) {
          $table->foreign('station')->references('id')->on('train_station')->onDelete('cascade');
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
