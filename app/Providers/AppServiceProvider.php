<?php

namespace App\Providers;

use App\Models\Tags;
use App\Services\GeneralServices;
use Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (env('APP_ENV') == 'production') {
			$this->app['request']->server->set('HTTPS', true);
		}
		// Force SSL in production
		if ($this->app->environment() == 'production') {
			URL::forceScheme('https');
		}
		
		// Set the default string length for Laravel5.4
		// https://laravel-news.com/laravel-5-4-key-too-long-error
		Schema::defaultStringLength(191);
		
		$this->services = new GeneralServices();
		try {
			$adds = $this->services->getAdds();
			view()->share('add1', isset($adds['data']->add1) ? $adds['data']->add1 : '');
			view()->share('add2', isset($adds['data']->add1) ? $adds['data']->add2 : '');
			view()->share('add3', isset($adds['data']->add1) ? $adds['data']->add3 : '');
		}catch (\Exception $e){
			view()->share('add1', '');
			view()->share('add2', '');
			view()->share('add3', '');
		}

		try {
			$modulesConfig = $this->services->getModuleConfig();
			if ($modulesConfig['status'] == 'success') {
				$celebritycheck = false;
				$videocheck = false;
				$multiSource = false;
				foreach($modulesConfig['data'] as $key => $val) {
					if($val->module_name == "Celebrities") {
						if ((int)$val->modulesStatus->status == 1) {
							$celebritycheck = true;
						}
					}

					if($val->module_name == "Groups") {
						if ((int)$val->modulesStatus->status == 1) {
							$videocheck = true;
						}
					}
					
					if($val->module_name == "Multi Source") {
						if ((int)$val->modulesStatus->status == 1) {
							$multiSource = true;
						}
					}
				}
				view()->share('celebrity_module', $celebritycheck);
				view()->share('video_groups_module', $videocheck);
				view()->share('multisource_videos', $multiSource);
			}
		} catch(\Exception $e) {
			view()->share('celebrity_module', false);
			view()->share('video_groups_module', false);
            view()->share('blog_module', false);
            view()->share('multisource_videos', false);
		}
		
		try {
			$data = $this->services->getAppName();

			if ($data['status'] == 'success') {
                if (isset($data['data'])) {
                    $webName = isset($data['data']->website_name) && $data['data']->website_name != '' ? $data['data']->website_name : 'Pak';
					$metaDescription = isset($data['data']->meta_description) ? $data['data']->meta_description : '';
					$metaTitle = isset($data['data']->meta_title) ? $data['data']->meta_title : '';
					$logo = isset($data['data']->website_logo) ? $data['data']->website_logo : asset('assets/client/images/logo.png');
					$favicon = isset($data['data']->website_favicon) ? $data['data']->website_favicon : asset('assets/client/images/favicon.png');
					$fb_app_id = isset($data['data']->fb_app_id) ? $data['data']->fb_app_id : '1417983228291795';
					$fb_app_secret = isset($data['data']->fb_app_secret) ? $data['data']->fb_app_secret : '1417983228291795';
					$fb_page_widget = isset($data['data']->fb_page_widget) ? $data['data']->fb_page_widget : '';
					$g_analytics = isset($data['data']->g_analytics) ? $data['data']->g_analytics : '1417983228291795';
					$smtp_user_host = isset($data['data']->smtp_user_host) ? $data['data']->smtp_user_host : '';
					$smtp_user_port = isset($data['data']->smtp_user_port) ? $data['data']->smtp_user_port : '';
					$smtp_user_name = isset($data['data']->smtp_user_name) ? $data['data']->smtp_user_name : '';
					$smtp_user_password = isset($data['data']->smtp_user_password) ? $data['data']->smtp_user_password : '';
					$smtp_user_encryption = isset($data['data']->smtp_user_encryption) ? $data['data']->smtp_user_encryption : '';
				} else {
					$webName = 'PakOneMedia';
					$metaDescription = '';
					$logo = asset('assets/client/images/logo.png');
					$favicon = asset('assets/client/images/favicon.png');
					$fb_app_id = '1417983228291795';
					$fb_app_secret = '1417983228291795';
					$fb_page_widget = '';
					$g_analytics = '1417983228291795';
					$smtp_user_host = '';
					$fb_page_widget = '';
					$smtp_user_port = '';
					$smtp_user_name = '';
					$smtp_user_password = '';
					$smtp_user_encryption = '';
				}
				
				Config::set('app.name', $webName);
//				Config::set('mail.host', $smtp_user_host );
//				Config::set('mail.port', $smtp_user_port );
//				Config::set('mail.username', $smtp_user_name );
//				Config::set('mail.password', $smtp_user_password );
//				Config::set('mail.encryption', $smtp_user_encryption);
				Config::set('services.facebook.client_id', $fb_app_id);
				Config::set('services.facebook.client_id', $fb_app_id);
				Config::set('services.facebook.client_secret', $fb_app_secret);
				
				view()->share('meta_title', $metaTitle);
				view()->share('meta_description', $metaDescription);
				view()->share('logo', $logo);
				view()->share('favicon', $favicon);
				view()->share('fb_app_id', $fb_app_id);
				view()->share('fb_page_widget', $fb_page_widget);
				view()->share('g_analytics', $g_analytics);
				view()->share('webName', $webName);
				view()->share('metaDescription', $metaDescription);
				view()->share('reciter_default_banner', asset('assets/client/images/reciter_default_banner.jpg'));
			}
		} catch (\Exception $e) {
			$metaDescription = '';
			$logo = asset('assets/client/images/logo.png');
			$favicon = asset('assets/client/images/favicon.png');
			$fb_app_id = '1417983228291795';
			$g_analytics = '1417983228291795';
			$fb_page_widget = '';
			$meta_title = '';

			view()->share('webName', '');
			view()->share('metaDescription', '');
			view()->share('meta_description', $metaDescription);
			view()->share('logo', $logo);
			view()->share('favicon', $favicon);
			view()->share('fb_app_id', $fb_app_id);
			view()->share('fb_page_widget', $fb_page_widget);
			view()->share('g_analytics', $g_analytics);
			view()->share('blog_module', false);
            view()->share('meta_title', $meta_title);
		}
		
		$tags  = Tags::get();
		view()->share('tags', $tags);
	}
	
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		/*
		 * Sets third party service providers that are only needed on local/testing environments
		 */
		if ($this->app->environment() !== 'production') {
			/**
			 * Loader for registering facades.
			 */
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			
			/*
			 * Load third party local providers
			 */
			$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
			$this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
			
			/*
			 * Load third party local aliases
			 */
			$loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
		}
	}
}
