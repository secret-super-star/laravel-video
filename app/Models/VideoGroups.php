<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VideoGroups extends Model
{
	protected $fillable = [
		'name',
		'thumbnail',
		'group_type',
		'date_recorded_urd',
		'date_recorded',
		'city_id',
		'place_id',
		'link',
		'created_by',
		'status'
	];

	public function getThumbnailAttribute($val){
		return \URL::to('/').'/imagecache/thumb/'.basename($val);
	}
	
	public function series()
	{
		return $this->hasMany('App\Models\VideoGroupsSeries', 'group_id', 'id');
	}

    public function category()
    {
        return $this->hasOne('App\Models\VideoGroupsCategoriesSeries', 'group_id','id');
	}

	public function createdByUser()
	{
		return $this->hasOne('App\Models\Auth\User\User', 'id', 'created_by');
	}
	
	public function cities()
	{
		return $this->hasOne('App\Models\Cities', 'id', 'city_id');
	}
	
	public function places()
	{
		return $this->hasOne('App\Models\Places', 'id', 'place_id');
	}

	public function groupCategory()
	{
		return $this->hasOne('App\Models\VideoGroupsCategoriesSeries', 'group_id', 'id');
	}

	public function groupLatestEightGroups()
	{
		return $this->orderBy('id', 'desc')->limit(8)->get();
	}
	
	public function getVideoGroupsByPlaceNamePaginate($city)
	{
		return $this
			->whereHas('places', function ($query) use($city) {
				$query->where('places.name', '=', $city);
			})
			->with('series', 'cities')
			->paginate(24);
	}

	public function getVideoGroupsByPlaceName($city)
	{
		return $this
			->whereHas('places', function ($query) use($city) {
				$query->where('places.name', '=', $city);
			})
			->with('series', 'cities')
			->get();
	}
	
	public function getVideoGroupsByCityNamePaginate($city)
	{
		return $this
			->whereHas('cities', function ($query) use($city) {
				$query->where('cities.name', '=', $city);
			})
			->with('series', 'cities')
			->paginate(24);
	}

	public function getVideoGroupsByCityName($city)
	{
		return $this
			->whereHas('cities', function ($query) use($city) {
				$query->where('cities.name', '=', $city);
			})
			->with('series', 'cities')
			->get();
	}
	
	public function getAllVideoGroups()
	{
		return $this->with('category.categoryDetail')->orderBy('id', 'desc')->get();
	}
	
	public function getVideoGroups($orderBy='', $sort='')
	{
		return $this
			   ->with('cities', 'places')
			   ->orderBy($orderBy,$sort)
			   ->paginate(24);
	}

	public function getVideoGroupsByCategory($orderBy='', $sort='', $category=false)
	{
		return $this
               ->whereHas('category',function($query) use ($category){
                   $query->whereRaw('groups_categories_id = ' . $category);
               })
               ->with('category')
			   ->orderBy($orderBy,$sort)
			   ->paginate(24);
	}
	
	public function getVideoGroupById($id)
	{
		return $this->with('series', 'groupCategory')->where('id', '=', $id)->first();
	}
	
	public function getVideoGroup()
	{
		return $this->with('series.seriesDetail.createdByUser', 'createdByUser')->get();
	}
	
	public function getVideoGroupByName($name)
	{
		return $this->with('series.seriesDetail.createdByUser', 'createdByUser')->where('link', '=', $name)->first();
	}
	
	public function createVideoGroups($request)
	{

//		$date= \Carbon\Carbon::parse($request->date_recorded)->toDateString();
//		dd($date);
		$date= \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_recorded);
//		dd($date);
		$dateRecorded = (\Carbon\Carbon::parse($date)->toDateString());
		$series = new Series();
		$link = $series->cleanTheLink($request['name']);
		$input = ([
			'name' => $request['name'],
			'group_type' => $request['group_type'],
			'date_recorded_urd' => $request['islamic_calender'],
			'link' => $link,
			'thumbnail' => $request['thumbnail'],
			'date_recorded' => $dateRecorded,
			'city_id' => $request['city_id'],
			'place_id' => $request['place_id'],
			'created_by' => Auth::user()->id,
			'status' => $request['publish']
		]);
		$input = array_filter($input, 'strlen');
		
		return $this->create($input);
	}
	
	public function updateVideoGroups($request, $id)
	{
		$date= \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_recorded)->toDateString();
		$dateRecorded = $date;
		$series = new Series();
		$link = $series->cleanTheLink($request['name']);
		$input = ([
			'name' => $request['name'],
			'group_type' => $request['group_type'],
			'date_recorded_urd' => $request['islamic_calender'],
			'name' => $request['name'],
			'link' => $link,
			'thumbnail' => $request['thumbnail'],
			'date_recorded' => $dateRecorded,
			'city_id' => $request['city_id'],
			'place_id' => $request['place_id'],
			'status' => $request['publish']
		]);
//		$input = array_filter($input, 'strlen');
		
		return $this->where('id', '=', $id)->update($input);
	}

	public function deleteVideoGroups($id)
	{
		return $this->where('id', '=', $id)->delete();
	}
}
