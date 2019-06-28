<?php

namespace App\Http\Controllers;

use App;
use App\Models\Series;
use URL;

class SitemapController extends Controller
{
	
	function __construct()
	{
		$this->series = new Series();
	}
	
	public function sitemap()
	{
		
		$view = view('sitemap',[
			'videos' => $this->series->getAllSeries(true, false)
		]);
		
		return response($view, 200)
			->header('Content-Type', 'text/xml');
	}
}
