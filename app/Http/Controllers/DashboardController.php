<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Auth\User\User;
use App\Models\Categories;
use App\Models\Countries;
use App\Models\Tags;
use App\Models\UsersLikedVideos;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
	
	function __construct()
	{
		$this->categories = new Categories();
		$this->tags = new Tags();
		$this->countries = new Countries();
		$this->generalService = new GeneralServices();
		$this->user = new User();
		$this->usersLikedVideos = new UsersLikedVideos();
	}
	
	public function index()
	{
		return view('client.dashboard',[
			'categories' => $this->categories->getCategories(false, true),
			'likedVideos' => $this->usersLikedVideos->getMyLikedVideos(),
			'tags' => $this->tags->getTags(),
			'countries' => $this->countries->get()
		]);
	}
	
	public function updateRecord(UpdateUserRequest $request)
	{
		
		$avatarName  = null;
		$bannerName = null;
		if (Input::file('avatar')) {
			$avatarName = ($this->generalService->uploadFile($request, 'uploads', 'avatar'));
		}
		
		if (Input::file('banner')) {
			$bannerName = ($this->generalService->uploadFile($request, 'uploads', 'banner'));
		}
		
		$request['bannerName'] = $bannerName['icon'];
		$request['avatarName'] = $avatarName['icon'];
		
		$resp = $this->user->updateUser($request);
		
		return redirect()->back();
	}
	
	public function likeVideo(Request $request)
	{
		if ($request->action == 1) {
			$this->usersLikedVideos->likeVideo($request->vid_id);
		} else {
			$this->usersLikedVideos->unlikeVideo($request->vid_id);
		}
		return collect([
			'status' => 'success'
		]);
	}
	
}
