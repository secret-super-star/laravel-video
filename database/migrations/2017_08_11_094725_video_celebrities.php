<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VideoCelebrities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('video_celebrities', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('series_id')->unsigned();
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
		    $table->integer('celebrities_id')->unsigned();
            $table->foreign('celebrities_id')->references('id')->on('celebrities')->onDelete('cascade');
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
        //
    }
}
