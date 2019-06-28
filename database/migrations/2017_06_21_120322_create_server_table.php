<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('servers', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('ip');
		    $table->integer('port');
		    $table->string('user');
		    $table->string('password');
			$table->string('domain')->nullable();
			$table->tinyInteger('sftp_status')->nullable()->default(0);
			$table->longText('sftp_root_path')->nullable();
			$table->integer('videos_uploaded')->nullable()->default(0);
			$table->tinyInteger('active')->default(0)->unsigned();
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
	    Schema::dropIfExists('servers');
    }
}
