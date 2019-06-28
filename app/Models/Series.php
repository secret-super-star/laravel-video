<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
	protected $table = 'series';

	protected $appends = ['OriginalImage'];

	protected $fillable = [
		'name',
		'link',
		'description',
		'featured',
		'thumbnail',
		'publish',
		'created_by',
		'active',
		'duration',
	];

	public function getThumbnailAttribute($value)
	{
		$thumb =  $value;
		$thumb = explode('/', $thumb);
		$length = count($thumb);
		$thumb = $thumb[$length-1];
		return \URL::to('/').'/assets/uploads/'.$thumb;
		return \URL::to('/').'/imagecache/thumb/'.$thumb;
	}

	public function getOriginalImageAttribute($value)
	{
		$thumb =  $this->thumbnail;
		$thumb = explode('/', $thumb);
		$length = count($thumb);
		$thumb = $thumb[$length-1];
		return \URL::to('/').'/assets/uploads/'.$thumb;
		return \URL::to('/').'/imagecache/original/'.$thumb;
	}

	public function getLinkAttribute($val)
	{
		return 	preg_replace('/[^a-zA-Z0-9]+/', ' ', $val);
	}
	
	public function seriesVideos()
	{
		return $this->hasMany('App\Models\SeriesVideos', 'series_id', 'id');
	}
	
	public function seriesCategory()
	{
		return $this->hasOne('App\Models\VideoCategories', 'series_id', 'id');
	}
	
	public function seriesTag()
	{
		return $this->hasMany('App\Models\VideoTags', 'series_id', 'id');
	}
	
	public function seriesTagSingle()
	{
		return $this->hasMany('App\Models\VideoTags', 'series_id', 'id');
	}
	
	public function createdByUser()
	{
		return $this->hasOne('App\Models\Auth\User\User', 'id', 'created_by');
	}
	
	public function videoViews()
	{
		return $this->hasMany('App\Models\SeriesVideosViews', 'series_id', 'id');
	}
	
	public function seriesCelebrities()
	{
		return $this->hasMany('App\Models\CelebritiesVideos', 'series_id', 'id');
	}

	public function cleanTheLink($val)
	{
		$a =  str_replace("/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s",' ',$val);
		$a = iconv("UTF-8", "ASCII//TRANSLIT", $a);
		$a = str_replace('?' , '', $a);
		$a = str_replace('>' , '', $a);
		$a = str_replace('<' , '', $a);
		$a = str_replace('^' , '', $a);
		$a = str_replace("’", ' ', $a);
		$a = str_replace("-", ' ', $a);
		$a = str_replace(":", ' ', $a);
		$a = str_replace("$", ' ', $a);
		$a = str_replace("/", ' ', $a);
		$a =  str_replace("%", ' ', $a);
		$a =  str_replace("@", ' ', $a);
		$a =  str_replace("#", ' ', $a);
		$a =  str_replace("&", ' ', $a);
		$a =  str_replace("*", ' ', $a);
		$a =  str_replace("(", ' ', $a);
		$a =  str_replace(")", ' ', $a);
		$a =  str_replace("-", ' ', $a);
		$a =  str_replace("+", ' ', $a);
		$a =  str_replace("=", ' ', $a);
		$a =  str_replace("{", ' ', $a);
		$a =  str_replace("}", ' ', $a);
		$a =  str_replace("[", ' ', $a);
		$a =  str_replace(",", ' ', $a);
		$a =  str_replace("]", ' ', $a);
		$a =  str_replace("|", ' ', $a);
		$a =  str_replace("'", ' ', $a);
		$a =  str_replace(":", ' ', $a);
		$a =  str_replace(";", ' ', $a);
		$a =  str_replace("!", ' ', $a);
		$a =  str_replace(')' , '', $a);
		$a =  str_replace('.' , '', $a);
		$a = trim($a);
		return preg_replace('!\s+!', ' ', $a);;
	}
	
	public function createSeries($request)
	{
		$obj = [
			'name' => $request->name,
			'link' => self::cleanTheLink($request->name),
			'description' => $request->description,
			'featured' => isset($request->featured) && $request->featured== 'on' ? 1 : 0,
			'publish' => isset($request->publish) && $request->publish== 'on' ? 1 : 0,
			'thumbnail' => isset($request['thumbnailImage'] ) ? $request['thumbnailImage']  :  'ok',
			'created_by' => Auth::user()->id,
			'active' => 1,
			'duration' => $request->duration1,
		];
		return $this->create($obj);
	}
	
	public function getMSDuration()
	{
		$m = intval($this->duration / 60);
		$s = ($this->duration % 60);
		
		return ($this->duration > 0) ? ($m < 10 ? '0' . $m : $m) . ':' . ($s < 10 ? '0' . $s : $s) : 0;
	}
	
	public function updateSeries($request)
	{
		$input = ([
			'name' => $request->name,
			'link' => self::cleanTheLink($request->name),
			'description' => $request->description,
			'featured' =>  isset($request->featured) && $request->featured == 'on' ? 1 : 0,
			'publish' => isset($request->publish) && $request->publish== 'on' ? 1 : 0,
			'thumbnail' => isset($request['thumbnailImage'] ) ? $request['thumbnailImage']  :  'ok',
//			'created_by' => Auth::user()->id,
			'active' => 1,
			'duration' => $request->duration1,
		]);
		$input = array_filter($input, 'strlen');
		return $this->where('id', '=', $request->series_id)->update($input);
	}
	
	public function getSeries($videoId)
	{
		return $this
			     ->with('seriesVideos', 'seriesCategory.subCategoryDetail', 'seriesCategory.categoryDetail', 'seriesTag.tagDetail', 'createdByUser', 'videoViews', 'seriesCelebrities.celebrityDetail')
			     ->where('id', '=', $videoId)
			     ->first();
	}
	
	public function getSeriesByName($name)
	{
		return $this
			     ->with('seriesVideos', 'seriesCategory.subCategoryDetail', 'seriesTag', 'createdByUser', 'videoViews')
			     ->where('link', '=', $name)
			     ->first();
	}
	
	public function getSeriesDetail($seriesId)
	{
		return $this
			->with('seriesVideos', 'seriesCategory', 'seriesTag', 'createdByUser', 'videoViews')
			->where('id', '=' , $seriesId)
			->orderBy('updated_at', 'desc')
			->get();
	}
	public function getAllSeriesWithPaginate($published=false)
	{
		$published = $published ? 'publish = 1' : '1=1';
		return $this
			->with('seriesVideos', 'seriesCategory.categoryDetail', 'seriesTag', 'createdByUser', 'videoViews')
			->whereRaw($published)
			->orderBy('created_at', 'desc')
			->paginate(24);
	}
	
	public function getNewSeries()
	{
		return $this
			->with('seriesVideos', 'seriesCategory.categoryDetail', 'seriesTag', 'createdByUser', 'videoViews')
			->where('publish', '=', 1)
			->where('featured', '=', 0)
			->orderBy('created_at', 'desc')
			->paginate(6);
	}
	
	public function getAllSeries($published=false, $latest20=false, $paginate=false)
	{
		if (!$paginate) {
			$paginate = $this->count();
		}
		
		if ($latest20) {
			$published = $published ? 'publish = 1' : '1=1';
			return $this
				->with('seriesVideos', 'seriesCategory.categoryDetail', 'seriesTag', 'createdByUser', 'videoViews')
				->whereRaw($published)
				->whereRaw($latest20)
				->orderBy('created_at', 'desc')
				->limit(24)
				->get();
		} else {
			$published = $published ? 'publish = 1' : '1=1';
			return $this
				->with('seriesVideos', 'seriesCategory.categoryDetail', 'seriesTag', 'createdByUser', 'videoViews')
				->whereRaw($published)
				->orderBy('created_at', 'desc')
				->paginate($paginate);
		}
	}
	
	public function getFeaturedSeries($published=false)
	{
		$published = $published ? 'publish = 1' : '1=1';
		return $this
			->with('seriesVideos', 'seriesCategory', 'seriesTag', 'createdByUser', 'videoViews')
			->where('featured', '=', 1)
			->whereRaw($published)
			->orderBy('updated_at', 'desc')
			->paginate(15);
	}
	
	public function getFeaturedAllSeries($published=true)
	{
		$published = $published ? 'publish = 1' : '1=1';
		return $this
			->with('seriesVideos', 'seriesCategory', 'seriesTag', 'createdByUser', 'videoViews')
			->where('featured', '=', 1)
			->whereRaw($published)
			->orderBy('updated_at', 'desc')
			->get();
	}
	
	public function getTagVideo($tagId, $published=false)
	{
		$published = $published ? 'publish = 1' : '1=1';
		return $this
			->whereHas('seriesTag', function ($query) use ($tagId){
				$query->whereRaw('video_tags.tag_id = '.$tagId);
			})
			->whereRaw($published)
			->with('seriesVideos', 'seriesCategory', 'seriesTag.tagDetail', 'createdByUser', 'videoViews')
			->orderBy('updated_at', 'desc')
			->paginate(20);
	}
	
	public function getCategoryVideo($catId, $published = false)
	{
		$published = $published ? 'publish = 1' : '1=1';
		return $this
			->whereHas('seriesCategory', function ($query) use ($catId){
				$query->whereRaw('video_categories.category_id = '.$catId)
					->orWhereRaw('video_categories.sub_category_id = '.$catId);
			})
			->whereRaw($published)
			->with('seriesVideos', 'seriesCategory.categoryDetail', 'seriesTag.tagDetail', 'createdByUser', 'videoViews')
			->orderBy('updated_at', 'desc')
			->paginate(24);
	}
	
	public function searchVideo($name)
	{
		return $this->where('name', 'LIKE', '%'.$name.'%')->orderBy('id', 'desc')->get();
	}
	
	public function getRecentThree()
	{
		return $this
			->with('createdByUser')
			->orderBy('id', 'desc')
			->limit(3)
			->get();
	}
}
