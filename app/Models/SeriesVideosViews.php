<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesVideosViews extends Model
{
	protected $table = 'series_videos_views';
	
	protected $fillable = [
		'series_id',
		'ip'
	];
	
	public function countView($ip, $sId)
	{
		$count = $this
			->where('series_id', '=', $sId)
			->where('ip', '=',$ip)
			->first();
		
		if ($count) {
			$this
				->create([
					'series_id' => $sId,
					'ip' => $ip,
				]);
		}
	}
}
