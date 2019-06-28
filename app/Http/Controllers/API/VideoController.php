<?php

namespace App\Http\Controllers\API;

use App\Models\Series;
use App\Models\SeriesVideosViews;
use App\Models\websiteConfiguration;
use App\Services\GeneralServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
	
	function __construct()
	{
		$this->generalService = new GeneralServices();
		$this->series = new Series();
		$this->seriesVideosView = new SeriesVideosViews();
		$this->websiteConfigurations = new websiteConfiguration();
	}
	
	public function getVideo(Request $request)
	{
		$seriesId = $request->video_id;
		
		$this->seriesVideosView->countView(\Request::ip(), $seriesId);
		$seriesData = $this->series->getSeries($seriesId);
		$arr = self::getRelatedVideos($seriesData);
		$newArr = array();
		
		$seriesData->video_views_count = isset($seriesData->videoViews) ? count($seriesData->videoViews) : 0;
		
		foreach ($seriesData->seriesVideos as $key => $val) {
			$path = $val->path;
			if (strpos($val->path, 'vimeo') > 0) {
				$pathBase = $this->generalService->generateVimeoLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
				};
			} else if(strpos($val->path, 'vid.me') > 0){
				$pathBase = $this->generalService->generateVidMeLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = isset($pathBase['url'][0]['file']) ? $pathBase['url'][0]['file'] : $pathBase['url'];
					foreach ($pathBase['url'] as $vidmekey => $vidmeval) {
						if ($key == 'default') {
							$path = $vidmeval['file'];
						}
					}
				};
			} else if (strpos($val->path, 'flickr') > 0) {
				$pathBase = $this->generalService->generateFlickrLink($val->path);
				if($pathBase['status'] == 'success') {
					$path = $pathBase['url'];
				};
			}

			array_push($newArr, array(
				"id" => $val->id,
				"series_id" => $val->series_id,
				"path" => $path,
				"created_at" => Carbon::parse($val->created_at)->toDateTimeString(),
				"updated_at" => Carbon::parse($val->updated_at)->toDateTimeString(),
			));
		}

		$seriesLink = asset('/').'video/'.str_replace('#', '_', str_replace(' ', '-', $seriesData->name));
		
		return response([
			'status' => 'success',
			'series_link' => $seriesLink,
			'series_videos' => $newArr,
			'series_data' => ($seriesData),
			'relatedSeries' => $arr,
		]);
	}
	
	public function getRelatedVideos($seriesData)
	{
		$arr  = array();
		foreach($seriesData->seriesTag as $val) {
			$videos = $this->series->getTagVideo($val->tag_id, true);
			foreach ($videos as $vid) {
				array_push($arr, $vid);
			}
		}
		return $arr;
	}
	
	public function homeScreen(Request $request)
	{
		$featuredVideo = $this->series->getFeaturedAllSeries();
		foreach ($featuredVideo as $key => $val) {
			$val->video_views_count = isset($val->videoViews) ? count($val->videoViews) : 0;
		}
		
		$seriesData = $this->series->getNewSeries();
		foreach ($seriesData as $key => $val) {
			$val->video_views_count = isset($val->videoViews) ? count($val->videoViews) : 0;
		}
		
		$websiteConfigurations = $this->websiteConfigurations->first();
		
		return response([
			'status' => 'success',
			'featuredVideos' => $featuredVideo,
			'newVideos' => $seriesData,
			'websiteConfigurations' => $websiteConfigurations
		]);
	}
	
	public function videoView(Request $request)
	{
		try {
			$ip = isset($request->ip) ? $request->ip : '';
			$seriesId = isset($request->series_id) ? $request->series_id : '';
			$this->seriesVideosView->countView($ip, $seriesId);
			return response([
				'status' => 'success',
			]);
		}catch (\Exception $e){
			return response([
				'status' => 'failure',
				'message' => $e->getMessage()
			]);
		}
	}
	
	public function searchVideo(Request $request)
	{
		try {
			if ($request->name == '') {
				$data = $this->series->getAllSeries(false, false, 4);
				$paginate = true;
			} else {
				$data = $this->series->searchVideo($request->name);
				$paginate = false;
			}
			return view('admin.videos.partials.listing',[
				'series' => $data,
				'paginate' => $paginate
			]);
		}catch (\Exception $e){
			
			return collect([
				'data' => $e->getMessage()
			]);
		}
	}
	
	public function validateVideo(Request $request)
	{
		$name = $this->series->cleanTheLink($request->name);
		$data = $this->series->getSeriesByName($name);
		return collect([
			'validate' => count($data)
		]);
	}
}
