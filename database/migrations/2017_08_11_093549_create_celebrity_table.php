<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCelebrityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('celebrities', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->string('image')->nullable();
		    $table->longText('bio')->nullable();
		    $table->date('dob')->nullable();
		    $table->string('city')->nullable();
		    $table->string('state')->nullable();
		    $table->string('country')->nullable();
		    $table->string('contact')->nullable();
			$table->text('banner')->nullable();
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
	    Schema::dropIfExists('celebrities');
    }
}
