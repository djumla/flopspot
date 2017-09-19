<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entrance')->unsigned();
            $table->integer('exit')->unsigned();
            $table->integer('trainNumber')->unsigned();
            $table->integer('rating')->unsigned();
            $table->timestamps();

            $table->foreign('entrance')->references('id')->on('train_station')->onDelete('cascade');
            $table->foreign('exit')->references('id')->on('train_station')->onDelete('cascade');
            $table->foreign('trainNumber')->references('id')->on('train_number')->onDelete('cascade');
            $table->foreign('rating')->references('id')->on('rating')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_info');
    }
}
