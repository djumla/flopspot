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
            $table->integer('station')->unsigned();
            $table->integer('rating')->unsigned();
            $table->timestamps();

            $table->foreign('station')
                  ->references('id')->on('train_station')
                  ->onDelete('cascade');
            $table->foreign('rating')
                  ->references('id')->on('rating')
                  ->onDelete('cascade');
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
