<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\MassEmails;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MassEmailsController extends Controller
{
	function __construct()
	{
		$this->user = new User();
	}
	
	public function index()
	{
			return view('admin.massEmails.emails');
	}
	
	public function postMassEmail(Request $request)
	{
		$users = $this->user->get();
		$this->dispatch(new MassEmails($request->content, $request->subject, $users));
		return redirect()->back();
		
	}
}
