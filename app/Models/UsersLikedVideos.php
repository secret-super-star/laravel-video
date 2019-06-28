<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UsersLikedVideos extends Model
{
	protected $fillable = [
		'user_id',
		'video_id',
	];
	
	public function videoDetail()
	{
		return $this->hasOne('App\Models\Series', 'id', 'video_id');
	}
	
	public function likeVideo($vidId)
	{
		$count = $this->where([
			'user_id' => Auth::user()->id,
			'video_id' => $vidId
		])->first();
		if (!isset($count)) {
			return $this->create([
				'user_id' => Auth::user()->id,
				'video_id' => $vidId
			]);
		}
	}
	
	
	public function unlikeVideo($vidId)
	{
		return $this->where([
			'user_id' => Auth::user()->id,
			'video_id' => $vidId
		])->delete();
	}
	
	public function getMyLikedVideos()
	{
		return $this->where('user_id', '=', Auth::user()->id)->with('videoDetail.createdByUser')->get();
	}
}
