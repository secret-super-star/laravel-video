<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Albums extends Model
{
	protected $fillable = [
		'name',
		'link',
		'thumbnail',
		'celebrity_id',
		'publish',
		'created_by',
		'updated_by'
	];
	
	public function series()
	{
		return $this->hasMany('App\Models\CelebrityAlbum', 'album_id', 'id');
	}
	
	public function celebrity()
	{
		return $this->hasOne('App\Models\Celebrities', 'id', 'celebrity_id');
	}
	
	public function createdByUser()
	{
		return $this->hasOne('App\Models\Auth\User\User', 'id', 'created_by');
	}
	
	public function updatedByUser()
	{
		return $this->hasOne('App\Models\Auth\User\User', 'id', 'updated_by');
	}
	
	public function getAlbums()
	{
		return $this->with('series.seriesDetail.seriesVideos', 'celebrity', 'createdByUser', 'updatedByUser')->orderBy('created_at', 'desc')->get();
	}
	
	public function getTopAlbums()
	{
		return $this->with('series.seriesDetail.seriesVideos', 'celebrity', 'createdByUser', 'updatedByUser')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);
	}
	
	public function getAlbumsById($id)
	{
		return $this->with('series.seriesDetail.seriesVideos', 'celebrity.celebritiesVideos.seriesDetail', 'createdByUser', 'updatedByUser')->where('id', '=', $id)->orderBy('created_at', 'desc')->first();
	}
	
	public function createAlbum($request)
	{
		$series = new Series();
		$link = $series->cleanTheLink($request['name']);
		$input = ([
			'name' => $request['name'],
			'link' => $link,
			'thumbnail' => $request['mythumbnail'],
			'celebrity_id' => $request['celebrity'],
			'publish' => $request['publish'],
			'created_by' => Auth::user()->id,
		]);
		$input = array_filter($input, 'strlen');
		return $this->create($input);
	}
	
	public function updateAlbum($request)
	{
		$series = new Series();
		$link = $series->cleanTheLink($request['name']);
		$input = ([
			'name' => $request['name'],
			'link' => $link,
			'thumbnail' => $request['mythumbnail'],
			'celebrity_id' => $request['celebrity'],
			'publish' => $request['publish'],
			'updated_by' => Auth::user()->id,
		]);
		$input = array_filter($input, 'strlen');
		$this->where('id', '=', $request->id)->update($input);
		
		return $this->where('id', '=', $request->id)->update($input);
	}

	public function deleteAlbum($id)
	{
		return $this->where('id', '=', $id)->delete();
	}

    public function getCelebrityAlbum($id)
    {
        return $this
            ->with(
                'series.seriesDetail.createdByUser')
            ->where('celebrity_id', '=', $id)
            ->get();
	}

    public function paginateCelebrityAlbum($id)
    {
        return $this
            ->with(
                'series.seriesDetail.createdByUser')
            ->where('celebrity_id', '=', $id)
            ->paginate(24);
	}
}
