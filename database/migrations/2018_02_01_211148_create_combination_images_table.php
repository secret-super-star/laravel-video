<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinationImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('combination_images', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('city_id')->unsigned();
		    $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
		    $table->integer('place_id')->unsigned();
		    $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
		    $table->string('image');
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
	    Schema::dropIfExists('video_groups_categories_series');
    }
}
