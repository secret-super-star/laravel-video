<?php

namespace App\Http\Controllers\API;

use App\Models\Series;
use App\Models\Tags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
	function __construct()
	{
		$this->tags = new Tags();
		$this->series = new Series();
	}
	
	public function getTags()
	{
		try {
			return response([
				'status' => 'success',
				'tags' => $this->tags->getTags()
			])->header('Content-Type', 'application/json');
		}catch (\Exception $e) {
			return response([
				'status' => 'false',
				'message' => 'Something went wrong, Please try again later',
				'code' => $e->getCode(),
				'technicalMessage' => $e->getMessage()
			]);
		}
	}
	
	public function getTagsVideos(Request $request)
	{
		$tagId = $request->tag_id;
		
		try {
			$seriesData = $this->series->getTagVideo($tagId, true);
			foreach ($seriesData as $key => $val) {
				$val->video_views_count = isset($val->videoViews) ? count($val->videoViews) : 0;
			}
			return response([
				'status' => 'success',
				'series' => $seriesData
			])->header('Content-Type', 'application/json');
		}catch (\Exception $e) {
			return response([
				'status' => 'false',
				'message' => 'Something went wrong, Please try again later',
				'code' => $e->getCode(),
				'technicalMessage' => $e->getMessage()
			]);
		}
	}
	
}
