<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cities;
use App\Models\Places;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
	
	function __construct()
	{
		$this->places = new Places();
		$this->cities = new Cities();
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, $id=false)
	{
		return view('admin.places.index',[
			'places' => $this->places->getPlaces($id)
		]);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->places->createPlaces($request);
		return redirect('/admin/places');
	}
	
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return view('admin.places.edit',[
			'data' => $this->places->getSinglePlacesById($id),
			'cities' => $this->cities->getAllCities()
		]);
	}
	
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
			$this->places->updatePlace($request, $id);
		return redirect('/admin/places');
	}
	
	/**
	 * Show the form for adding the specified resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function add()
	{
		return view('admin.places.add',[
			'cities' => $this->cities->getAllCities()
		]);
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->places->where('id', '=', $id)->delete();
		return redirect('/admin/places');
	}
}
