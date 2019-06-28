<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoGroupsSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('video_groups_series', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('video_groups')->onDelete('cascade');
		    $table->integer('series_id')->unsigned();
			$table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
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
	    Schema::dropIfExists('video_groups_series');
    }
}
