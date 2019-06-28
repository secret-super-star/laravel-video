<?php

namespace App\Http\Controllers\API;

use App\Models\Places;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
	function __construct()
	{
		$this->places = new Places();
	}
	
	public function getPlaces(Request $request)
	{
		$places = $this->places->getPlaces($request->city_id);
		return collect([
			'status' => 'success',
			'data' => $places
		]);
	}
}
