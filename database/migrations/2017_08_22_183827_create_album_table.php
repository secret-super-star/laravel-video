<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('albums', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->nullable();
		    $table->string('thumbnail');
		    $table->tinyInteger('publish');
		    $table->integer('celebrity_id')->unsigned();
			$table->foreign('celebrity_id')->references('id')->on('celebrities')->onDelete('cascade');;
		    $table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
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
	    Schema::dropIfExists('albums');
    }
}
