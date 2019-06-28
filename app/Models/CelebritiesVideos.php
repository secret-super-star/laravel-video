<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelebritiesVideos extends Model
{

	protected $table = 'video_celebrities';

	public function seriesDetail()
	{
		return $this->hasOne('App\Models\Series', 'id', 'series_id');
	}

	public function celebrityDetail()
	{
		return $this->hasOne('App\Models\Celebrities', 'id', 'celebrities_id');
	}

	public function getCelebrityVideo($id)
	{
		return $this
			   ->whereHas('seriesDetail', function($q){
				   $q->where('publish', '=', 1);
			   })
			   ->with('seriesDetail.createdByUser')
			   ->where('celebrities_id', '=', $id)
				 ->orderBy('id', 'desc')
			   ->paginate(27);
	}
}
