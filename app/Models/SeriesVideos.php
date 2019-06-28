<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesVideos extends Model
{
	protected $table = 'series_videos';
	
	protected $fillable = [
		'series_id',
		'path',
		'source_type',
		'thumbnail',
		'duration',
		'source_no'
	];
	
	public function createSeriesVideos($id, $path, $type=false, $duration = 0, $thumbnail = '', $sourceNo=0)
	{
		return $this->create([
			'series_id' => $id,
			'path' => $path,
			'source_type' => $type,
			'duration' => $duration,
			'thumbnail' => '',
			'source_no' => $sourceNo

		]);
	}

	public function updateSeriesVideos($series_id, $path, $type=false, $id, $duration = 0, $thumbnail = '')
	{
		return $this->where('id', '=', $id)->update([
			'path' => $path,
			'source_type' => $type,
			'duration' => $duration,
			'thumbnail' => $thumbnail
		]);
	}
}
