<?php

namespace App\Http\Controllers\API;

use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	
	
	function __construct()
	{
		$this->user = new User();
	}
	
	public function login(Request $request)
	{
		$email = $request->email;
		$pass = $request->password;
		
		if (\Auth::attempt(['email' => $email, 'password' => $pass])) {
			$user = \Auth::user();
			$token =  $user->createToken('MyApp')->accessToken;

			return collect([
				'status' => 'success',
				'data' => $user,
				'token' => $token
			]);
		} else {
			return collect([
				'status' => 'false',
				'data' => 'User record not found in our database..!'
			]);
		}
		
	}
	
	public function reset(Request $request)
	{
		$email = $request->email;
		
		$usr = $this->user->where('email', '=', $email)->first();
		if (count($usr) > 0) {
			return collect([
				'status' => 'success',
				'message' => 'Email has been sent with instructions..!'
			]);
		} else {
			return collect([
				'status' => 'failure',
				'message' => 'User not found...!'
			]);
		}
	}
	
	public function register(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'c_password' => 'required|same:password',
		]);
		
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}
		
		$input = $request->all();
		$input['password'] = bcrypt($input['password']);
		$user = User::create($input);
		$success['token'] =  $user->createToken('MyApp')->accessToken;
		$success['name'] =  $user->name;
		
		return response()->json(['success'=>$success], 200);
	}
	
	/**
	 * details api
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function details()
	{
		$user = Auth::user();
		return response()->json(['success' => $user], 200);
	}
	
}
