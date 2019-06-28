<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tags;
use Barryvdh\Reflection\DocBlock\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
	function __construct()
	{
		$this->tags = new Tags();
	}
	
	public function index(Request $request)
	{
		return view('admin.tags.index',[
			'tags' => $this->tags->getTags()
		]);
	}
	
	public function addTags(Request $request)
	{
		return view('admin.tags.add');
	}
	
	public function postAddTags(TagRequest $request)
	{
		$this->tags->createTags($request);
		return redirect('/admin/tags');
	}
	
	public function getCategory($tagId)
	{
		return view('admin.tags.edit',[
			'tags' => $this->tags->getTags($tagId)
		]);
	}
	
	public function updateTags(TagRequest $request)
	{
		$res = $this->tags->updateTags($request);
		return redirect('/admin/tags');
	}
	
	public function deleteTags($id)
	{
		$this->tags->deleteTags($id);
		return redirect('/admin/tags');
	}
	
}
