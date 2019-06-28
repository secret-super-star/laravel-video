<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
	
	function __construct()
	{
		$this->cities = new Cities();
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.cities.index',[
			'cities' => $this->cities->orderBy('name', 'asc')->get()
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
		$this->cities->createCity($request);
		return redirect('/admin/cities');
	}
	
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return view('admin.cities.edit',[
			'data' => ($this->cities->where('id', '=', $id)->first())
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
		$this->cities->updateCity($request, $id);
		return redirect('/admin/cities');
	}
	
	/**
	 * Show the form for adding the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function add()
	{
		return view('admin.cities.add');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->cities->where('id', '=', $id)->delete();
		return redirect('/admin/cities');
	}
}
