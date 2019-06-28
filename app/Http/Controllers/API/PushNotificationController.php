<?php

namespace App\Http\Controllers\API;

use App\Models\Series;
use App\Models\UserDeviceToken;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
	
	function __construct()
	{
		$this->service = new GeneralServices();
		$this->series = new Series();
		$this->token = new UserDeviceToken();
	}
	
	public function sendNotification(Request $request)
	{
		$deviceToken  = $request->token;
		$data = $this->series->getAllSeries();
		$this->service->androidPush(array($deviceToken), $data[0]);
	}
	


	public function saveToken(Request $request) {

		$user_id = $request->user_id ? $request->user_id  : '';
		$token = $request->token;



		


		
		if(isset($request->user_id_iphone)){
			$request->user_id_iphone = $request->user_id_iphone;
		}else{
			$request->user_id_iphone = '';
		}




		if(isset($request->device_type)){
			$request->device_type = $request->device_type;
		}else{
			$request->device_type = '';
		}

		

		

		if($request->device_type != ""){

				if($this->token->tokenExits($request->all())){
					$data = $this->token->updateUserToken($request->all());			
				}else{
					$data = $this->token->createToken($request->all());						
				}
		}else{

				$data = $this->token->createToken($request->all());	

		}
		


				
		

		 
		/*
		if($user_id_iphone !='')){
			if($this->token->tokenExits($request->all())){
				$data = $this->token->createToken($request->all());	
			}else{
				$data = $this->token->updateUserToken($request->all());			
			}
		}else{

		
			$data = $this->token->createToken($request->all());		
		}


		*/
		return response($data);
	}
}

