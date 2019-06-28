<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
	protected $fillable = [
		'name',
		'name_urd',
		'thumbnail'
	];
	
	public function places()
	{
		return $this->hasMany('App\Models\Places', 'city_id', 'id');
	}
	
	public function createCity($request)
	{
		$input = ([
			'name' => $request['name'] ? $request['name'] : '',
			'name_urd' => $request['name_urd'] ? $request['name_urd'] : '',
			'thumbnail' => $request['mythumbnail'] ? $request['mythumbnail'] : ''
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->create($input);
	}
	
	public function updateCity($request, $id)
	{
		$input = ([
			'name' => $request['name'] ? $request['name'] : '',
			'name_urd' => $request['name_urd'] ? $request['name_urd'] : '',
			'thumbnail' => $request['mythumbnail'] ? $request['mythumbnail'] : ''
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->where('id', '=', $id)->update($input);
	}
	
	public function getCities()
	{
		return $this->orderBy('name', 'asc')->paginate(24);
	}

	public function getAllCities()
	{
		return $this->with('places')->orderBy('name', 'asc')->get();
	}
	
	public function getCityPlacesByName($name)
	{
		return $this->where('name', '=', $name)->first();
	}
}
