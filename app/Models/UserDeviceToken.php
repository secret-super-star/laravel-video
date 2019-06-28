<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceToken extends Model
{
	protected $table = 'user_device_token';
	
	protected $fillable = [
		'user_id',
		'token',
		'device_type',
		'user_id_iphone'
	];
	
	public function createToken($request)
	{
		try {
			return collect([
				'status' => 'success',
				'data' => $this->create($request)
			]);
		} catch (\Exception $e){
			return collect([
				'status' => 'failure',
				'message' => $e->getMessage()
			]);
		}
	}
	
	public function getAllTokens()
	{
		return $this->pluck('token');
	}



	public function getAllTokensIOS() {
		return $this->where('device_type', 'ios')->pluck('token');
	}




	//here gs 
	public function updateUserToken($request){
		$user_id_iphone = $request['user_id_iphone'] ;

		$input = ([
			'token' => $request['token'] ? $request['token'] : ''
		]);
		$input = array_filter($input, 'strlen');
		return $this->where('user_id_iphone', '=', $user_id_iphone)->update($input);
	}



	public function tokenExits($request){

		$user_id_iphone = $request['user_id_iphone'];
		$userExitsCheck = $this->where('user_id_iphone', '=', $user_id_iphone)->first();

		if(count($userExitsCheck)>0){
			return true;
		}else{
			return false;
		}

	}





}
