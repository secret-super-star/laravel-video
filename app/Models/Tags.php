<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
	protected $fillable = [
		'tag',
		'tag_description'
	];
	
	public function getTags($id=false)
	{
		if ($id) {
			return $this->where('id', '=', $id)->first();
		} else {
			return $this->get();
		}
	}
	
	public function createTags($request)
	{
		return $this->create([
			'tag' => $request['tag'] ? $request['tag'] : '',
			'tag_description' => $request['tag_description'] ? $request['tag_description'] : ''
		]);
	}
	
	public function updateTags($request)
	{
		return $this->where('id', '=', $request['id'])->update([
			'tag' => $request['tag'] ? $request['tag'] : '',
			'tag_description' => $request['tag_description']? $request['tag_description'] : ''
		]);
	}
	
	public function deleteTags($request)
	{
		return $this->where('id', '=', $request)->delete();
	}
	
}
