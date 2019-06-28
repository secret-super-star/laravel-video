<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cities;
use App\Models\CombinationImages;
use App\Models\Places;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CombinationController extends Controller
{
	
	protected $combinationImages;
	
	public function __construct()
	{
		$this->combinationImages = new CombinationImages();
		$this->cities = new Cities();
		$this->place = new Places();
	}
	
	public function index()
	{
			return view('admin.combination.index',[
				'data' => $this->combinationImages->getImages()
			]);
	}
	
	public function show()
	{
		$cities = $this->cities->getAllCities();
		return view('admin.combination.add',[
			'data' => $cities
		]);
	}
	
	public function create(Request $request)
	{
		$data = array();
		if($request->parent) {
			$data = ($this->combinationImages->where('city_id', '=', $request->city_id)->where('is_parent', '=', 1)->first());
		} else {
			$data = $this->combinationImages->where('city_id', '=', $request->city_id)->where('place_id', '=', $request->place_id)->first();
		}
		if(isset($data)) {
			return redirect()->back()->withInput()->with('error', 'It seems you\'ve already uploaded image..!');
		}
		$this->combinationImages->createImage($request);
		return redirect('/admin/combination-images');
	}
	
	public function edit(Request $request, $id)
	{
		$data = $this->combinationImages->getImageDetail($id);
		$places = $this->place->getPlaces($data->city_id);
		$cities = $this->cities->getAllCities();
		return view('admin.combination.edit',[
			'data' => $data,
			'cities' => $cities,
			'places' => $places
		]);
	}
	
	public function update(Request $request, $id)
	{
		$request['id'] = $id;
		$this->combinationImages->updateImage($request);
		return redirect('/admin/combination-images');
	}
	
}
