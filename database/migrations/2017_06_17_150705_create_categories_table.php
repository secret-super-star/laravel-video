<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('category_title')->unique();
			$table->text('category_description');
			$table->string('category_image');
			$table->integer('parent')->comment('0= Main Category')->default(0)->nullable()->unsigned();
			$table->foreign('parent')->references('id')->on('categories')->onDelete('cascade');;
			$table->integer('custom_order')->nullable();
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
		Schema::dropIfExists('categories');
	}
}
