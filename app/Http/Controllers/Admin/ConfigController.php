<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use App\Services\GeneralServices;
use App\Models\websiteConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class ConfigController extends Controller
{
	
	function __construct()
	{
		$this->services = new GeneralServices();
		$this->websiteConfiguration = new websiteConfiguration();
		$this->websiteContent = new WebsiteContent();
	}
	
	public function websiteConfiguration(Request $request)
	{
//		dd($this->websiteConfiguration->getConfig());
		return view('admin.configuration.websiteConfiguration',[
			'config' => $this->websiteConfiguration->getConfig()
		]);
	}
	
	public function configureWebsite(Request $request)
	{
		if (Input::file('web_logo')) {
			$weblogo = $this->services->uploadFile($request, '/uploads', 'web_logo');
			$request['website_logo'] = URL::to('/').'/uploads/'.$weblogo['icon'];
		}
		if (Input::file('web_favicon')) {
			$webfavicon = $this->services->uploadFile($request, '/uploads', 'web_favicon');
			$request['website_favicon'] = URL::to('/').'/uploads/'.$webfavicon['icon'];
		}
		$this->websiteConfiguration->setConfig($request);
		return redirect()->back();
	}
	
	public function privacyPolicy(Request $request)
	{
		return view('admin.configuration.privacy',[
			'config' => $this->websiteContent->getPrivacyPolicy()
		]);
	}
	
	public function postPrivacyPolicy(Request $request)
	{
		$this->websiteContent->createPrivacyPolicy($request);
		return redirect()->back();
	}
	
	public function TOS(Request $request)
	{
		return view('admin.configuration.tos',[
			'config' => $this->websiteContent->getTOS()
		]);
	}
	
	public function postTOS(Request $request)
	{
		$this->websiteContent->createTOS($request);
		return redirect()->back();
	}
	
}
