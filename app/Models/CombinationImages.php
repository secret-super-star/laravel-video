<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CombinationImages extends Model
{
	protected $table = 'combination_images';
	
	protected $fillable = [
		'city_id',
		'place_id',
		'is_parent',
		'image',
	];

	public function getImagePathAttribute($image)
	{
		return strstr($this->attributes['image'], 'assets');
	}

	public function cityDetail()
	{
		return $this->hasOne('App\Models\Cities', 'id', 'city_id');
	}
	
	public function placeDetail()
	{
		return $this->hasOne('App\Models\Places', 'id', 'place_id');
	}
	
	public function getImages()
	{
		return $this->with('cityDetail', 'placeDetail')->get();
	}
	
	public function createImage($request)
	{
		$input= [
			'city_id' => $request['city_id'],
			'place_id' => $request['place_id'],
			'is_parent' => isset($request['parent']) && $request['parent'] == 'on' ?  1 : 0,
			'image' => $request['mythumbnail'],
		];
		
		$input = array_filter($input, 'strlen');
		return $this->create($input);
	}
	
	public function updateImage($request)
	{
		$input = [
			'city_id' => $request['city_id'],
			'place_id' => $request['place_id'],
			'image' => $request['mythumbnail'],
		];
		$input = array_filter($input, 'strlen');
		return $this->where('id', '=', $request['id'])->update($input);
	}
	
	public function getImageDetail($id)
	{
		return $this->where('id', '=', $id)->with('cityDetail', 'placeDetail')->first();
	}
	
	public function getImageDetailByCitAndPlace($cityId, $placeId)
	{
		if($placeId == null) {
			return $this
				->where('city_id', '=', $cityId)
				->where('is_parent', '=', 1)
				->with('cityDetail', 'placeDetail')
				->first();
		} else {
			return $this
				->where('city_id', '=', $cityId)
				->where('place_id', '=', $placeId)
				->with('cityDetail', 'placeDetail')
				->first();
		}
	}
}
