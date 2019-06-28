<?php

namespace App\Http\Controllers;

use App\Models\Albums;
use App\Models\Auth\User\User;
use App\Models\Categories;
use App\Models\Celebrities;
use App\Models\CelebritiesVideos;
use App\Models\CelebrityAlbum;
use App\Models\Cities;
use App\Models\Places;
use App\Models\Series, Cache;
use App\Models\Countries;
use App\Models\SeriesVideosViews;
use App\Models\Tags;
use App\Models\UsersLikedVideos;
use App\Models\VideoGroups;
use App\Models\VideoGroupsCategories;
use App\Models\VideoGroupsSeries;
use App\Models\WebsiteContent;
use App\Models\WebsiteModules;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Common;
use App\Helpers\Base64WithKey;

class IndexController extends Controller
{

	public function __construct()
	{
		$this->categories = new Categories();
		$this->tags = new Tags();
		$this->series = new Series();
		$this->seriesVideosView = new SeriesVideosViews();
		$this->generalService = new GeneralServices();
		$this->privacy = new WebsiteContent();
		$this->celebrity = new Celebrities();
		$this->album = new Albums();
		$this->celebrityAlbum = new CelebrityAlbum();
		$this->users = new User();
		$this->countries = new Countries();
		$this->cities = new Cities();
		$this->places = new Places();
		$this->videoGroups = new VideoGroups();
		$this->celebrityVideos = new CelebritiesVideos();
		$this->groupCategories = new VideoGroupsCategories();
		$this->videoGroups = new VideoGroups();
		$this->videoGroupsSeries = new VideoGroupsSeries();
	}

	public function index()
	{
//		dd($this->celebrity->getCelebrities(5));
		return view('client.index',[
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'featuredSeries' => $this->series->getFeaturedSeries(true),
			'series' => $this->series->getAllSeries(true, true),
      'videoGroups' => $this->videoGroups->groupLatestEightGroups(),
			'celebrities' => $this->celebrity->getCelebrities(20),
			'albums' => $this->album->getTopAlbums()
		]);
	}

	public function seriesVideosDailymotion($path = false) {

		$m3u8 = '';

		if ($path)
		{
			$url = decrypt($path);

			if (!empty($url) && Cache::has($url))
			{
				$m3u8 = Cache::get($url);
			}
		}

		return response($m3u8)
			->header('Content-Type', 'application/vnd.apple.mpegurl');
	}

	public function seriesVideos($seriesName, $seriesId, Request $request) {
		$seriesName = ($this->generalService->cleanVideoName($seriesId));
		$seriesData = ($seriesData = $this->series->getSeriesByName($seriesName));
		$part = isset($request->p) ? (int)$request->p-1 : 0;
		
		if(isset($seriesData->publish) && $seriesData->publish == 0) {
			return redirect('/404');
		}
		
		$seriesId = $seriesData->id;

		$this->seriesVideosView->countView(\Request::ip(), $seriesId);
		$seriesData = $this->series->getSeries($seriesId);
		$arr = self::getRelatedVideos($seriesData);
		$newArr = array();
		
		
		$this->websiteModule = new WebsiteModules();
		$m = $this->websiteModule->getSingleModules('Multi Source');
		
		$vid = array();
		if(isset($m->modulesStatus) && isset($m->modulesStatus->status) && $m->modulesStatus->status == 1){
			$path = '';
			$videos = array();
			foreach ($seriesData->seriesVideos as $key => $val) {
				array_push($videos, $val);
			}
			
			$vid[0] = $videos[$part];

		}else {
				array_push($vid, $seriesData->seriesVideos[0]);
		}

		foreach ($vid as $key => $val) {
			$path = $val->path;


			$type = 'mp4';
			if (stripos($val->path, 'vimeo') > 0) {
				$pathBase = $this->generalService->generateVimeoLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'hls';
				};
			} 
			// elseif (stripos($val->path, 'yadi.sk') > 0) {
				// $pathBase = $this->generalService->generateYandexLink($val->path);
				// if($pathBase['status'] == 'success') {
					// $path = $pathBase['url'];
					// $type = 'mp4';
				// };
			// } 
			elseif (stripos($val->path, 'dailymotion') > 0) {
				$pathBase = $this->generalService->generateDailymotionLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'hls';
				};
			} elseif (stripos($val->path, 'vid.me') > 0){
				$pathBase = $this->generalService->generateVidMeLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'video/mp4';
					$fallback_url = $pathBase['fallback_url'];
				};
			} elseif (stripos($val->path, 'flickr') > 0) {
				$pathBase = $this->generalService->generateFlickrLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'mp4';
				};
			} elseif (preg_match('#youtube.com|youtu.be#is', $val->path)){
				$pathBase = $this->generalService->generateYoutubeLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'video/mp4';
					$fallback_url = $pathBase['fallback_url'];
				};
			} elseif (preg_match('#facebook.com|fb.com#is', $val->path)){
				$pathBase = $this->generalService->generateFacebookLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'video/mp4';
				};
			} elseif (preg_match('#bestream#is', $val->path)){
				$pathBase = $this->generalService->generateBestreamLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'video/mp4';
				};
			} elseif (preg_match('#box.com#is', $val->path)){
				$pathBase = $this->generalService->generateBoxLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'video/mp4';
				};
			} elseif (stripos($val->path, 'fembed') !== false) {
				$pathBase = $this->generalService->generateFembedLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
					$type = 'video/mp4';
					$fallback_url = $pathBase['fallback_url'];
				};
			} elseif (stripos($val->path, 'sv1.siliptv.net') !== false) {
				$today = gmdate("n/j/Y g:i:s A");
				$ip = Common::getClientIP();
				$key = "cukec@2020";
				$validminutes = 30;
				$str2hash = $ip . $key . $today . $validminutes;
				$md5raw = md5($str2hash, true);
				$base64hash = base64_encode($md5raw);
				$urlsignature = "server_time=" . $today ."&hash_value=" . $base64hash. "&validminutes=$validminutes";
				$base64urlsignature = base64_encode($urlsignature);

				$path = $val->path . "?wmsAuthSign=$base64urlsignature";
				$type = 'hls';
			} elseif (stripos($val->path, 'cloud.mail.ru') !== false) {
				$path = 'https://gnouv.com/goom3/mplayer.php?l=' . Base64WithKey::encode($val->path);
				$type = 'iframe';
			} elseif (stripos($val->path, 'yadi.sk') !== false) {
				$path = 'https://gnouv.com/goom3/yplayer.php?l=' . Base64WithKey::encode($val->path);
				$type = 'iframe';
			} else {
				$path = $val->path;
				$type = 'iframe';
			}

			$likedBit = false;
			if(Auth::user()) {
				$this->usersLikedVideo = new UsersLikedVideos();
				$liked = $this
					->usersLikedVideo
					->where('user_id', '=', Auth::user()->id)
					->where('video_id', '=', $val->series_id)
					->first();
				if (isset($liked)) {
					$likedBit = true;
				}
			}

			$tmp = array(
				"id" => $val->id,
				"series_id" => $val->series_id,
				"path" => $path,
				"type" => $type,
				"thumbnail" => $val->thumbnail,
				"created_at" => $val->created_at,
				"updated_at" => $val->updated_at,
			);

			if (isset($fallback_url))
			{
				$tmp['fallback_url'] = $fallback_url;
			}

			array_push($newArr, $tmp);
		}
		
		return view('client.seriesVideo',[
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'series' => $seriesData,
			'relatedSeries' => $arr,
			"liked" => $likedBit ? $likedBit : false,
			'seriesVideo' => json_encode($newArr),
			'p' => $part
		]);
	}

	public function getRelatedVideos($seriesData)
	{
		$arr  = array();
		foreach($seriesData->seriesTag as $val) {
			$videos = $this->series->getTagVideo($val->tag_id, true);
			foreach ($videos as $vid) {
				if(count($arr) > 5) {
					break;
				}
				array_push($arr, $vid);
			}
		}
		
		return $arr;
	}

	public function getTagId($tag)
	{
		try {
			$tag1 = $this->tags->where('tag', '=', str_replace('-', ' ', $tag))->first();
			if(isset($tag1->id) && $tag1->id) {
				return 	$tag1->id;
			}
		} catch (\Exception $e){
			return 0;
		}
	}

	public function tagVideos($tag)
	{
		$tagId = self::getTagId($tag);
		if ($tagId < 1) {
			return redirect('/404');
		}
		return view('client.tagVideosSpecific',[
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'tagName' => str_replace('-', ' ', $tag),
			'series' => $this->series->getTagVideo($tagId, true)
		]);
	}

	public function getCatId($category)
	{
		try {
			$cat = $this->categories->getCategoryByName(str_replace('-', ' ', $category));
			$categoryId = $cat->id;
			if (isset($categoryId) && $categoryId > 0) {
				return $categoryId;
			} else {
				return 0;
			}
		}catch (\Exception $e) {
			return 0;
		}
	}

	public function categoryVideos($category)
	{
		$categoryId = self::getCatId($category);
		$data = $this->categories->getSubCategories($categoryId, true);
		
		if (is_null($data) || count($data->subCategories) < 1) { //fetch show videos
			return view('client.categoriesVideos',[
				'categoriesName' => $this->categories->where('id','=', $categoryId)->first(),
				'categories' => $this->categories->getCategories(false, true),
				'tags' => $this->tags->getTags(),
				'series' => $this->series->getCategoryVideo($categoryId, true)
			]);
		} else { // show categories
			//TODO: Removing this case as per requirement on 5th JAN 2018
			return redirect('/watch');
			return view('client.subcategoriesViews',[
				'categoriesName' => $this->categories->where('id','=', $categoryId)->first(),
				'categories' => $this->categories->getCategories(false, true),
				'tags' => $this->tags->getTags(),
				'subCategories' => $data->subCategories,
			]);
		}
	}

	public function Videos()
	{
		return view('client.watch',[
			'categoriesName' => '',
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'series' => $this->series->getAllSeriesWithPaginate(true)
		]);
	}

	public function categories()
	{
		return view('client.subcategoriesViews',[
			'categoriesName' => '',
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'subCategories' => $this->categories->orderBy('custom_order', 'desc')->where('parent', '=', NULL)->get(),
		]);
	}

	public function filterSeries(Request $request)
	{
//		dd($request['query']);
		$resp =	Series::where('name', 'LIKE', "%".$request['query']."%")->get();

		$arr = array();
		foreach ($resp as $key=> $val) {
			$name = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "-", $val->name));
			array_push($arr, array(
				'value' => $val->id,
				'label' => strlen($name) > 45 ? substr($name,0,45)."..." : $name,
				'thumb' => $val->thumbnail,
				'link' => str_replace(' ', '-' , $val->link),
			));
		}

		return \Response::json(($arr));
	}

	public function terms()
	{
		return view('client.terms',[
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'content' => $this->privacy->getTOS()
		]);
	}

	public function privacy()
	{
		return view('client.privacy',[
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'content' => $this->privacy->getPrivacyPolicy()
		]);
	}

	public function celebrityPage($celebrityName)
	{
		$celebrityName = $this->series->cleanTheLink($celebrityName);
		$data = $this->celebrity->getCelebrityByName($celebrityName);
		$videos = $this->celebrityVideos->getCelebrityVideo($data->id);

		return view('client.celebrityDashboard',[
			'likedVideos' => 10,
			'data' => $data,
			'videos' => $videos
		]);
	}

	public function sendPush(Request $request)
	{
		$this->service = new GeneralServices();
		dd($this->service->androidPush('fvD48Ub2kb8:APA91bEdES7eTaUPUdR05kGPiQjuAS4Ij0_f4idowbmCQ9pTudRNjiz4IINR-8Sl4fRiWTo0ayyUMYRhX2rIIdcbS1RAwqeMbhskfOOvRCOlUYwXnJrRDZ_oGScxu0lfkaGR4awrDHjl', 'he bro'));
		dd(1);
	}

	public function albumDetail($albumName)
	{
		$albumName = $this->series->cleanTheLink($albumName);
		$id= $this->album->where('link' , '=', $albumName)->first();
		$data = $this->celebrityAlbum->getAlbumById($id->id);
//		dd($data[0]->seriesDetailSingle->thumbnail);
		return view('client.albumDetail',[
			'series' => $data,
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'albumName' => $albumName
		]);
	}

	public function celebrities(Request $request)
	{
		return view('client.celebrities',[
			'celebrities' => $this->celebrity->getCelebrities(30),
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
		]);
	}

	public function users(Request $request)
	{
		return view('client.users',[
			'celebrities' => $this->users->paginate(42),
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
		]);
	}

	public function usersDetail($name)
	{
		$name = $this->generalService->cleanVideoName($name);
		$usrDetail = $this->users->getUserDetailByName($name);
		return view('client.publicDashboard',[
			'user' => $usrDetail,
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'countries' => $this->countries->get()
		]);
	}

	public function cities(Request $request)
	{
		return view('client.cities',[
			'categoriesName' => '',
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'cities' => $this->cities->getCities(),
		]);
	}

	public function citiesPlaces($name)
	{
		$name = $this->generalService->cleanVideoName($name);
		$city = $this->cities->where('name', '=', $name)->first();
		$cityId = isset($city->id) ?$city->id : '';
		if ($cityId) {
			$places = $this->places->getAllPlaces($city->id);
//			if(count($places) > 0) {
//				return view('client.cities', [
//					'categoriesName' => '',
//					'categories' => $this->categories->getCategories(false, true),
//					'tags' => $this->tags->getTags(),
//					'cities' => $places,
//				]);
//			} else {
				return view('client.videoGroups',[
					'categoriesName' => 'abc',
					'categories' => $this->categories->getCategories(false, true),
					'tags' => $this->tags->getTags(),
					'series' => $this->videoGroups->getVideoGroupsByCityNamePaginate($name),
					'places' => $places,
					'groupVideos' => true,
                    'cityName' => $city->name
				]);
//			}
		} else {
			$data = $this->videoGroups->getVideoGroupsByPlaceNamePaginate($name);
			$placeName = isset($data[0]) && isset($data[0]->cities->name) ? $data[0]->cities->name : '';
			$name = ($placeName .' / '.$name);
			return view('client.videoGroups',[
				'categoriesName' => 'abc',
				'categories' => $this->categories->getCategories(false, true),
				'tags' => $this->tags->getTags(),
				'series' => $data,
				'groupVideos' => true,
        'cityName' => $name,
			]);
		}
	}

	public function groups()
	{
		return view('client.videoGroups',[
			'categoriesName' => 'abc',
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'series' => $this->videoGroups->getVideoGroups($orderBy='date_recorded', $sort='desc'),
			'groupCategories' => $this->groupCategories->getGroupCategories(),
			'groupVideos' => true
		]);
	}

	public function groupsCategories($category)
	{
        $name = $this->generalService->cleanVideoName($category);
        $category = $this->groupCategories->where('link', '=', $name)->first();
        $category = isset($category->id) ?$category->id : '';

		return view('client.videoCategoryGroups',[
			'categoriesName' => 'abc',
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'series' => $this->videoGroups->getVideoGroupsByCategory($orderBy='date_recorded', $sort='desc', $category),
			'groupCategories' => $this->groupCategories->getGroupCategories(),
			'groupVideos' => true
		]);
	}

	public function groupVideos(Request $request, $groupName)
	{
		$groupName = $this->generalService->cleanVideoName($groupName);
		$data = $this->videoGroups->getVideoGroupByName($groupName);
		$series = $this->videoGroupsSeries->getSeriesData($data->id);
		return view('client.videoGroupsDetail',[
			'categoriesName' => '',
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->getTags(),
			'series' => $series,
			'createdBy' => $data->createdByUser,
            'groupName' => isset($data->name) ? $data->name : $groupName
		]);
	}
}
