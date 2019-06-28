<?php

namespace App\Http\Controllers;

use App\Services\GeneralServices;
use Illuminate\Http\Request;
use League\Flysystem\Config;

class SSHController extends Controller
{
	
	function __construct()
	{
		$this->service = new GeneralServices();
	}
	
	public function index()
	{
		dd(\File::delete(public_path('uploads/1500308064__3.mp4')));
//		dd($this->service->getLowerTrafficServer());
//		\Config::set('remote.connections.production.host', '192.58.1.1');
//		dd(\SSH::into('production'));
//		dd(public_path('assets/uploads/categories/1497879064__Screenshot from 2017-05-05 02-46-55.png'));
//		dd(asset('uploads/categories/1497879064__Screenshot from 2017-05-05 02-46-55.png'));
//		dd(\SSH::into('production')->getString('/var/www/pakone.tv/5 - Video Detail.png'));
		try {
			dd(\SSH::into('production')->put(
				public_path('uploads/1500301393__1.mp4'),
				'/var/www/cdn1.filiptv.com/public/1500301393__1.mp4'
			));
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	
	
	}
	
}
