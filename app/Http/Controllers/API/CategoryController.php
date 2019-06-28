<?php

namespace App\Http\Controllers\API;

use App\Models\Categories;
use App\Models\Series;
use App\Models\Tags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
	
	function __construct()
	{
		$this->categories = new Categories();
		$this->tags = new Tags();
		$this->series = new Series();
	}
	
	public function getCategories(Request $request)
	{
		try {
			$id = isset($request->id) ? $request->id : false;
			$parent = isset($request->parent) ? $request->parent : false;
			$cat = $this->categories->getCategories($id, $parent);
			return response([
				'status' => 'success',
				'data' => $cat
			])->header('Content-Type', 'application/json');
		} catch (\Exception $e) {
			return response([
				'status' => 'false',
				'message' => 'Something went wrong, Please try again later',
				'code' => $e->getCode(),
				'technicalMessage' => $e->getMessage()
			])->header('Content-Type', 'application/json');
		}
	}
	
	public function getCategoriesVideos(Request $request)
	{
		try {
			$categoryId = $request->cat_id;
			$data = $this->categories->getSubCategories($categoryId, true);
			
			if (is_null($data) || count($data->subCategories) < 1) { //fetch show videos
				$seriesData = $this->series->getCategoryVideo($categoryId, true);
				foreach ($seriesData as $key => $val) {
					$val->video_views_count = isset($val->videoViews) ? count($val->videoViews) : 0 ;
				}
				return response([
					'status' => 'success',
					'videos' => true,
					'categoriesName' => $this->categories->where('id', '=', $categoryId)->first(),
					'series' => $seriesData
				])->header('Content-Type', 'application/json');
			} else { // show categories

				return response([
					'status' => 'success',
					'videos' => false,
					'categoriesName' => $this->categories->where('id', '=', $categoryId)->first(),
					'subCategories' => $data->subCategories,
				]);
			}
		} catch (\Exception $e) {
			return response([
				'status' => 'false',
				'message' => 'Something went wrong, Please try again later',
				'code' => $e->getCode(),
				'technicalMessage' => $e->getMessage()
			])->header('Content-Type', 'application/json');
		}
	}
	
	public function getCategoriesAndTags()
	{
		try {
			$cat = $this->categories->getCategories(false, true);
			$tags = $this->tags->getTags();
			return response([
				'status' => 'success',
				'categories' => $cat,
				'tags' => $tags,
				'watches' => $tags
			]);
		} catch (\Exception $e) {
			return response([
				'status' => 'false',
				'message' => 'Something went wrong, Please try again later',
				'code' => $e->getCode(),
				'technicalMessage' => $e->getMessage()
			])->header('Content-Type', 'application/json');
		}
	}
	
}
