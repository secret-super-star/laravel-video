<?php

namespace App\Models;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
	protected $fillable  = [
		'city_id',
		'name',
		'name_urd',
		'thumbnail'
	];
	
	public function city()
	{
		return $this->hasOne('App\Models\Cities', 'id', 'city_id');
	}
	
	public function createPlaces($request)
	{
		$input = ([
			'city_id' => $request['city_id'] ? $request['city_id'] : '',
			'name' => $request['name'] ? $request['name'] : '',
			'name_urd' => $request['name_urd'] ? $request['name_urd'] : '',
			'thumbnail' => $request['mythumbnail'] ? $request['mythumbnail'] : ''
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->create($input);
	}
	
	public function updatePlace($request, $id)
	{
		$input = ([
			'city_id' => $request['city_id'] ? $request['city_id'] : '',
			'name' => $request['name'] ? $request['name'] : '',
			'name_urd' => $request['name_urd'] ? $request['name_urd'] : '',
			'thumbnail' => $request['mythumbnail'] ? $request['mythumbnail'] : ''
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->where('id', '=', $id)->update($input);
	}
	
	public function getPlaces($id = false)
	{
		if ($id) {
			return $this
						->whereHas('city', function ($query) use ($id){
							$query->where('cities.id', '=' ,$id);
						})
						->with('city')
					->orderBy('name', 'asc')	
				    ->get();
		} else {
			return $this->with('city')->get();
		}
	}
	
	public function getPlacesWithPaginate($id = false)
	{
		if ($id) {
			return $this
						->whereHas('city', function ($query) use ($id){
							$query->where('cities.id', '=' ,$id);
						})
						->with('city')
					->orderBy('name', 'asc')	
				    ->paginate(24);
		} else {
			return $this->with('city')->get();
		}
	}

	public function getAllPlaces($id = false)
	{
		if ($id) {
			return $this
						->whereHas('city', function ($query) use ($id){
							$query->where('cities.id', '=' ,$id);
						})
						->with('city')
					->orderBy('name', 'asc')
				    ->get();
		} else {
			return $this->with('city')->get();
		}
	}

	public function getSinglePlacesById($id)
	{
		return $this->with('city')->where('id', '=', $id)->first();
	}
}
