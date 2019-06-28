<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelebrityAlbum extends Model
{
	protected $table = 'celebrity_albums';
	
	protected $fillable = [
		'series_id',
		'album_id'
	];
	
	public function albumDetail()
	{
		return $this->hasOne('App\Models\Albums', 'id', 'album_id');
	}
	
	public function seriesDetail()
	{
		return $this->hasMany('App\Models\Series', 'id', 'series_id');
	}
	
	public function seriesDetailSingle()
	{
		return $this->hasOne('App\Models\Series', 'id', 'series_id');
	}
	
	public function createCelebrityAlbum($celebId, $albumId, $seriesId)
	{
		$input = ([
			'series_id' => $seriesId,
			'album_id' => $albumId,
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->create($input);
	}
	
	public function deleteCelebrityAlbum($albumId)
	{
		return $this->where('album_id', '=', $albumId)->delete();
	}
	
	public function getCelebrityById($id)
	{
		return $this->with('albumDetail', 'seriesDetail')->where('id', '=', $id)->get();
	}
	
	public function getAlbumById($id)
	{
		return $this->with('seriesDetailSingle', 'albumDetail')->where('album_id', '=', $id)->get();
	}

	public function paginateAlbumById($id)
	{
		return $this->with('seriesDetailSingle', 'albumDetail')->where('album_id', '=', $id)->paginate(24);
	}
	
}
