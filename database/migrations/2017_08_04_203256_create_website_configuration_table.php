<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('website_configurations', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('website_name')->default('PakOneMedia');
		    $table->string('website_logo')->default(env('BASE_APP_URL').'assets/client/images/logo.png');
		    $table->string('website_favicon')->default(env('BASE_APP_URL').'assets/client/images/logo.png');
		    $table->longText('meta_title')->nullable();
		    $table->longText('meta_description')->nullable();
		    $table->longText('g_adsense')->nullable();
		    $table->longText('g_analytics')->nullable();
		    $table->longText('fb_app_id')->nullable();
		    $table->longText('fb_app_secret')->nullable();
		    $table->longText('fb_page_widget')->nullable();
		    $table->string('smtp_user_name')->nullable();
		    $table->string('smtp_user_password')->nullable();
		    $table->string('smtp_user_host')->nullable();
		    $table->string('smtp_user_port')->nullable();
		    $table->string('smtp_user_encryption')->nullable();
		    $table->longText('video_description')->nullable();
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
	    Schema::dropIfExists('website_configurations');
    }
}
