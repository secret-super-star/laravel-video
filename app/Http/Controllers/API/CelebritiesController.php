<?php

namespace App\Http\Controllers\API;

use App\Models\Albums;
use App\Models\Celebrities;
use App\Models\CelebritiesVideos;
use App\Models\CelebrityAlbum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CelebritiesController extends Controller
{
	
	function __construct()
	{
		$this->celebrities = new Celebrities();
		$this->celebrityVideos = new CelebritiesVideos();
		$this->albums = new Albums();
		$this->celebrityAlbum = new CelebrityAlbum();
	}

	public function getCelebrityDetail($id)
	{
		$data = $this->celebrities->getCelebrityById($id);
		return collect([
			'status' => 'success',
			'data' => $data
		]);
	}

	public function getCelebrityVideoDetail($id)
	{
		$data = $this->celebrityVideos->getCelebrityVideo($id);
		return collect([
			'status' => 'success',
			'data' => $data
		]);
	}

	public function getCelebrityAlbumsDetail($id)
	{
		$data = $this->albums->paginateCelebrityAlbum($id);
		return collect([
			'status' => 'success',
			'data' => $data
		]);
	}

	public function getCelebrities()
	{
		return collect([
			'status' => 'success',
			'data' => $this->celebrities->getCelebrities(24)
		]);
	}

	public function getCelebrityVideos(Request $request)
	{
		return collect([
			'status' => 'success',
			'data' => $this->celebrities->getCelebrityById($request->id)
		]);
	}

    public function getAlbumsDetail($albumId)
    {
        $data = $this->celebrityAlbum->paginateAlbumById($albumId);
        return collect([
            'status' => 'success',
            'data' => $data
        ]);
	}
}
