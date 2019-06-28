<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCelebrityAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('celebrity_albums', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('album_id')->unsigned();
			$table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');;
		    $table->integer('series_id')->unsigned();
			$table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');;
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
	    Schema::dropIfExists('celebrity_albums');
	
    }
}
