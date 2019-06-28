<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCategories extends Model
{
	protected $table = 'video_categories';
	
	protected $fillable = [
		'series_id',
		'category_id',
		'sub_category_id'
	];
	
	public function categoryDetail()
	{
		return $this->hasOne('App\Models\Categories', 'id', 'category_id');
	}
	
	public function subCategoryDetail()
	{
		return $this->hasOne('App\Models\Categories', 'id', 'sub_category_id');
	}
}
