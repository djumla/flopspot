<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entrance')->unsigned();
            $table->integer('exit')->unsigned();
            $table->integer('trainNumber')->unsigned();
            $table->integer('rating')->unsigned();
            $table->timestamps();

            $table->foreign('entrance')->references('id')->on('train_stations')->onDelete('cascade');
            $table->foreign('exit')->references('id')->on('train_stations')->onDelete('cascade');
            $table->foreign('trainNumber')->references('id')->on('train_numbers')->onDelete('cascade');
            $table->foreign('rating')->references('id')->on('ratings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
