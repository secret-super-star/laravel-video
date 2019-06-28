<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class websiteConfiguration extends Model
{
	protected $fillable = [
		'website_name',
		'website_logo',
		'website_favicon',
		'meta_title',
		'meta_description',
		'g_adsense',
		'g_analytics',
		'fb_app_id',
		'fb_page_widget',
		'smtp_user_name',
		'smtp_user_password',
		'smtp_user_host',
		'smtp_user_port',
		'smtp_user_encryption',
		'website_theme',
		'video_description'
	];

	public function getWebsiteLogoAttribute($value) {
		$val = explode('/', $value);
		$len = count($val);
		$image = $val[$len-1];
		$image = URL::to('/imagecache/logThumb/').'/'.$image;
		return $image;
	}

	public function getConfig()
	{
		return $this->first();
	}
	
	public function setConfig($request)
	{
		$input = ([
			'website_name' => $request['website_name'],
			'website_logo' => $request['website_logo'],
			'website_favicon' => $request['website_favicon'],
			'website_theme' => $request['website_theme'],
			'meta_title' => $request['meta_title'],
			'meta_description' => $request['meta_description'],
			'g_adsense' => $request['g_adsense'],
			'g_analytics' => $request['g_analytics'],
			'fb_app_id' => $request['fb_app_id'],
			'fb_app_secret' => $request['fb_app_secret'],
			'fb_page_widget' => $request['fb_page_widget'],
			'smtp_user_name' => $request['smtp_user_name'],
			'smtp_user_password' => $request['smtp_user_password'],
			'smtp_user_host' => $request['smtp_user_host'],
			'smtp_user_port' => $request['smtp_user_port'],
			'smtp_user_encryption' => $request['smtp_user_encryption'],
			'video_description' => $request['video_description'],
		]);
		$input = array_filter($input, 'strlen');
		$count =  $this->first();
		if (count($count) < 1) {
			$this->create($input);
		} else {
			$this->where('id', '=', $count->id)->update($input);
		}
	}
}
