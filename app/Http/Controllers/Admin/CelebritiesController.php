<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateCelebrityRequest;
use App\Models\Albums;
use App\Models\Celebrities;
use App\Models\CelebrityAlbum;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Series;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CelebritiesController extends Controller
{
	function __construct()
	{
		$this->celebrities = new Celebrities();
		$this->countries = new Countries();
		$this->services = new GeneralServices();
		$this->albums = new Albums();
		$this->celebrityAlbum = new CelebrityAlbum();
		$this->cities = new Cities();
		$this->series = new Series();
	}

	public function index()
	{
		return view('admin.celebrities.index',[
			'celebrities' => $this->celebrities->getAllCelebrities()
		]);
	}

	public function createCelebrity(Request $request)
	{
		return view('admin.celebrities.add',[
			'countries' => $this->countries->get(),
			'cities' => $this->cities->getCities()
		]);
	}

	public function postCreateCelebrity(CreateCelebrityRequest $request)
	{
		if($request->mythumbnail) {
			$request['image'] = $request->mythumbnail;
		} else {
			$request['image'] = null;
		}

		if($request->bannerThumb) {
			$request['banner'] = $request->bannerThumb;
		} else {
			$request['banner'] = null;
		}
		$this->celebrities->createCelebrity($request);
		return redirect('/admin/celebrities');
	}

	public function EditCreateCelebrity($celebrityName)
	{
		$celebrityName = $this->series->cleanTheLink($celebrityName);
		$data = $this->celebrities->getCelebrityByName($celebrityName);
		return view('admin.celebrities.edit',[
			'celebrity' => $data,
			'countries' => $this->countries->get(),
			'cities' => $this->cities->getCities()
		]);
	}

	public function postEditCreateCelebrity(Request $request)
	{
		if($request->mythumbnail) {
			$request['image'] = $request->mythumbnail;
		} else {
			$request['image'] = null;
		}

		if($request->bannerThumb) {
			$request['banner'] = $request->bannerThumb;
		} else {
			$request['banner'] = null;
		}

		$this->celebrities->updateCelebrity($request);
		return redirect('/admin/celebrities');
	}

	public function deleteCelebrity($id)
	{
		$this->celebrities->deleteCelebrityById($id);
		return redirect()->back();
	}

	public function celebrityAlbum(Request $request)
	{
//		dd($this->albums->getAlbums()->toJson());
		return view('admin.celebritiesAlbum.index',[
			'albums' => $this->albums->getAlbums()
		]);
	}

	public function postCelebrityAlbum(Request $request)
	{
		\DB::transaction(function () use ($request) {
			$album =  $this->albums->createAlbum($request);
			$albumId = $album->id;
			$celebrityId = $request->celebrity;
			foreach ($request->celebrityVideo as $key => $val) {
				$this->celebrityAlbum->createCelebrityAlbum($celebrityId, $albumId, $val);
			}
		});
		return redirect()->back();
	}

	public function newCelebrityAlbum(Request $request)
	{
		return view('admin.celebritiesAlbum.add',[
			'celebrities' => $this->celebrities->getCelebrities()
		]);
	}

	public function editCelebrityAlbum($id)
	{
		$data = $this->albums->getAlbumsById($id);
//		dd($data);
		return view('admin.celebritiesAlbum.edit', [
			'celebrities' => $this->celebrities->getCelebrities(),
			'data' => $data
		]);
	}

	public function postEditCelebrityAlbum(Request $request)
	{
		\DB::transaction(function () use ($request) {
			$album =  $this->albums->updateAlbum($request);
			$albumId = $request->id;
			$celebrityId = $request->celebrity;
			$this->celebrityAlbum->deleteCelebrityAlbum($albumId);

			foreach ($request->celebrityVideo as $key => $val) {
				$this->celebrityAlbum->createCelebrityAlbum($celebrityId, $albumId, $val);
			}
		});
		return redirect()->back();
	}

	public function deleteCelebrityAlbum($id)
	{
		$this->albums->deleteAlbum($id);
		$this->celebrityAlbum->deleteCelebrityAlbum($id);
		return redirect()->back();
	}
}
