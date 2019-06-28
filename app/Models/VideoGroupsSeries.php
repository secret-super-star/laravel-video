<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGroupsSeries extends Model
{
	protected $fillable = [
		'group_id',
		'series_id'
	];
	
	public function seriesDetail()
	{
		return $this->hasOne('App\Models\Series', 'id', 'series_id');
	}
	
	public function createAlbumSeries($val, $groupId)
	{
		return $this->create([
			'group_id' => $groupId,
			'series_id' => $val,
		]);
	}
	
	public function deleteAlbumSeries($groupId)
	{
		return $this->where('group_id', '=', $groupId)->delete();
	}
	
	public function getSeriesData($groupId)
	{
		return $this
			->with('seriesDetail.createdByUser')
			->where('group_id', '=', $groupId)
			->paginate(24);
	}
}
