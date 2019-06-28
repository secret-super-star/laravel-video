<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celebrities extends Model
{
	protected $fillable = [
		'name',
		'image',
		'banner',
		'bio',
		'dob',
		'city',
		'state',
		'link',
		'contact',
		'country'
	];
	
	public function getImageAttribute($value)
	{
		$thumb =  $value;
		$thumb = explode('/', $thumb);
		$length = count($thumb);
		$thumb = $thumb[$length-1];
		return \URL::to('/').'/imagecache/thumb/'.$thumb;
	}
	
	public function celebritiesVideos()
	{
		return $this->hasMany('App\Models\CelebritiesVideos', 'celebrities_id', 'id')->orderBy('id', 'desc');
	}
	
	public function countryDetail()
	{
		return $this->hasOne('App\Models\Countries', 'short_name', 'country');
	}
	
	public function album()
	{
		return $this->hasMany('App\Models\Albums', 'celebrity_id', 'id');
	}

	public function cityLocated() {
		return $this->hasOne('App\Models\Cities', 'id', 'city');
	}
	
	public function createCelebrity($request)
	{
		$this->seriesController = new Series();
		$link = $this->seriesController->cleanTheLink($request['name']);
		$input = ([
			'name' => $request['name'] ? $request['name'] : null,
			'image' => $request['image'] ? $request['image'] : null,
			'link' => $link,
			'banner' => $request['banner'] ? $request['banner'] : null,
			'bio' => $request['bio'] ? $request['bio'] : null,
			'dob' => $request['dob'] ? $request['dob'] : null,
			'contact' => $request['contact'] ? $request['contact'] : null,
			'city' => $request['city'] ? $request['city'] : null,
			'country' => $request['country'] ? $request['country'] : null,
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->create($input);
	}
	
	public function updateCelebrity($request)
	{
		$this->seriesController = new Series();
		$link = $this->seriesController->cleanTheLink($request['name']);
		$input = ([
			'name' => $request['name'] ? $request['name'] : null,
			'image' => $request['image'] ? $request['image'] : null,
			'link' => $link,
			'banner' => $request['banner'] ? $request['banner'] : null,
			'bio' => $request['bio'] ? $request['bio'] : null,
			'dob' => $request['dob'] ? $request['dob'] : null,
			'contact' => $request['contact'] ? $request['contact'] : null,
			'city' => $request['city'] ? $request['city'] : null,
			'country' => $request['country'] ? $request['country'] : null,
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->where('id', '=', $request->id)->update($input);
	}
	
	public function getCelebrities($count=false)
	{
		if (!$count) {
			$count = $this->count();
		}
		
		return $this
					 ->with('celebritiesVideos.seriesDetail', 'cityLocated')
				->orderBy('name', 'asc')
			     ->paginate($count);
	}
	
	public function getAllCelebrities()
	{
		return $this
					 ->with('celebritiesVideos.seriesDetail', 'cityLocated')
				->orderBy('name', 'asc')
			     ->get();
	}
	
	public function getCelebrityByName($name)
	{
		return $this
					 ->with('celebritiesVideos.seriesDetail.createdByUser', 'countryDetail', 'album.createdByUser', 'cityLocated')
					 ->where('link', '=', $name)
			     ->first();
	}

	public function getCelebrityById($id)
	{
		return $this
			->with(
				'celebritiesVideos.seriesDetail.createdByUser',
				'countryDetail',
				'album.series.seriesDetail.createdByUser',
				'album.createdByUser',
				'cityLocated'
			)
			->where('id', '=', $id)
			->first();
	}
	
	public function deleteCelebrityById($id)
	{
		return $this
			->where('id', '=', $id)
			->delete();
	}
}
