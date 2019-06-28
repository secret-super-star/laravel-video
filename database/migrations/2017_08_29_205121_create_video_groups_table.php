<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('video_groups', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->string('thumbnail');
		    $table->date('date_recorded')->nullable();
		    $table->integer('city_id')->unsigned();
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');;
		    $table->integer('place_id')->nullable()->unsigned();
			$table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');;
		    $table->integer('created_by')->nullable();
		    $table->integer('status');
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
	    Schema::dropIfExists('video_groups');
    }
}
