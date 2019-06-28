<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('series', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique('name');
		    $table->string('link')->unique('link');
		    $table->longText('description');
		    $table->string('duration')->nullable();
		    $table->tinyInteger('active')->default(0)->unsigned();
			$table->integer('featured')->default(0)->nullable()->comment('1= featured');
			$table->string('thumbnail')->nullable();
			$table->string('created_by')->nullable();
			$table->string('duration')->change();
			$table->tinyInteger('publish')->nullable()->default(0);
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
	    Schema::dropIfExists('series');
    }
}
