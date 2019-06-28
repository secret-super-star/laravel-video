<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteContent extends Model
{
	
	protected $table = 'website_content';
	
	protected $fillable = [
		'type',
		'content'
	];
	
	public function createPrivacyPolicy($request)
	{
		$data = $this->where('type' , '=', 'PrivacyPolicy')->first();
		if (count($data) < 1) {
			$this->create([
				'type' => 'PrivacyPolicy',
				'content' => $request->content
			]);
		} else {
			$this->where('id', '=', $data->id)->update([
				'type' => 'PrivacyPolicy',
				'content' => $request->content
			]);
		}
	}
	
	public function getPrivacyPolicy()
	{
		return ($this->where('type' ,'=', 'PrivacyPolicy')->first());
	}
	
	public function createTOS($request)
	{
		$data = $this->where('type' , '=', 'TOS')->first();
		if (count($data) < 1) {
			$this->create([
				'type' => 'TOS',
				'content' => $request->content
			]);
		} else {
			$this->where('id', '=', $data->id)->update([
				'type' => 'TOS',
				'content' => $request->content
			]);
		}
	}
	
	public function getTOS()
	{
		return $this->where('type' ,'=', 'TOS')->first();
	}
}
