<?php

namespace App\Http\Controllers\Admin;

use App\Models\Series;
use App\Models\UserDeviceToken;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
	
	function __construct()
	{
		$this->videos = new Series();
		$this->tokens = new UserDeviceToken();
		$this->series = new Series();
		$this->service = new GeneralServices();
	}
	
	public function index(Request $request)
	{
		return view('admin.notification.index',[
			'videos' => $this->videos->getAllSeries()
		]);
	}
	
	public function sendNotification(Request $request)
	{



		$deviceToken  = $this->tokens->getAllTokens()->toArray();
		
		
		$seriesId  = $request->series_id;
		$data = $this->series->getSeries($seriesId);
		
		
		$this->service->androidPush($deviceToken, $data);

		

		$deviceIOS = $this->tokens->getAllTokensIOS()->toArray();

		if(count($deviceIOS)>0){
			$this->service->iosPush($deviceIOS, $data);
		}


		
		return redirect()->back();
	}
}
