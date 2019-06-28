<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Categories extends Model
{
	
	protected $fillable = [
		'category_title',
		'category_description',
		'category_image',
		'parent',
		'custom_order'
	];
	
	public function getCategoryImageAttribute($value)
	{
//		if(strpos($value, 'uploads') === false) {
//			return URL::to('/') . '/assets/uploads/categories/' . $value;
//		} else {
//			return $value;
//		}
		$thumb =  $value;
		$thumb = explode('/', $thumb);
		$length = count($thumb);
		$thumb = $thumb[$length-1];
		return \URL::to('/').'/imagecache/medium/'.$thumb;
	}

	public function subCategories()
	{
		return $this->hasMany(self::class, 'parent');
	}

	public function parentCategory()
	{
		return $this->hasOne('App\Models\Categories', 'id', 'parent');
	}
	
	public function getSubCategories($id=false, $parent = false)
	{
		return
			$this
				->with(['subCategories' => function($query){
					$query->orderBy('category_title', 'asc');
				}])
				->where('id', '=', $id)
				->orderBy('category_title', 'asc')
				->first();
	}
	
	public function getCategoryByName($categoryTitle)
	{
		return
			$this
				->with('subCategories')
				->where('category_title', '=', $categoryTitle)
				->first();
	}
	
	public function getCategories($id=false, $parent=false)
	{
		if ($id) {
			return
				  $this
					->with('subCategories')
					->where('id', '=', $id)
					->first();
		} else {
			if ($parent) {
				return
					$this
						->with('parentCategory', 'subCategories')
						->where('parent', '=', NULL)
						->orderBy('custom_order', 'dsc')
						->get();
			} else {
				return
					$this
						->with('parentCategory')
						->orderBy('custom_order', 'dsc')
						->get();
			}
		}
	}
	
	public function createCategories($request)
	{
		$parent = '';
		if ($request->parent_category) {
			$parent = NULL;
		} else {
			$parent = $request['parent'];
		}
		$input = ([
			'category_title' => $request['category_title'] ? $request['category_title'] : NULL,
			'category_description' => $request['category_description'] ? $request['category_description'] : NULL,
			'category_image' => $request['uploaded_category_image'] ? $request['uploaded_category_image'] : NULL,
			'parent' => $parent,
		]);
//		$input = array_filter($input, 'strlen');
		return $this->create($input);
	}
	
	public function updateCategories($request)
	{
		$parentVal = '';
		if ($request->parent_category) {
			$parent = NULL;
		} else {
			$parent = $request['parent'];
		}
		$input = ([
			'category_title' => $request['category_title'] ? $request['category_title'] : NULL,
			'category_description' => $request['category_description'] ? $request['category_description'] : NULL,
			'category_image' => $request['uploaded_category_image'] ? $request['uploaded_category_image'] : NULL,
			'parent' => $parent,
		]);
		$input = array_filter($input, 'strlen');
		return $this->where('id', '=', $request['category_id'])->update($input);
	}
}
