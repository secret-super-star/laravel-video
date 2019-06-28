<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTags extends Model
{
	protected $table = 'video_tags';
	
	protected $fillable = [
		'series_id',
		'tag_id'
	];
	
	public function tagDetail()
	{
		return $this->hasOne('App\Models\Tags', 'id', 'tag_id');
	}
}
