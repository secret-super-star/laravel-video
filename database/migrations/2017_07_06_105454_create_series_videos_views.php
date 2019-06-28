<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesVideosViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('series_videos_views', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('series_id')->unsigned();
			$table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
		    $table->string('ip');
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
	    Schema::dropIfExists('series_videos_views');
    }
}
