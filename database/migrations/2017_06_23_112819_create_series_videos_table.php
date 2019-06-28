<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('series_videos', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('series_id')->unsigned();
			$table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
			$table->text('path');
			$table->string('duration')->nullable();
		    $table->string('thumbnail');
			$table->integer('source_type')->nullable()->comment('1= Path, 2=File Upload');
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
	    Schema::dropIfExists('series_videos');
    }
}
