<?php

namespace App\Http\Middleware;

use App\Models\websiteConfiguration;
use Cache;
use Closure;

/**
 * Created this middleware to change the theme as it has been selected on admin portal
*/

class ThemeSelection
{
	protected $configuration;
	
	public function __construct()
	{
		$this->configuration = new websiteConfiguration();
	}
	
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		
		/*Using Cache to get the theme selection from database*/
//		if(!Cache::has('theme')) {
			$config = $this->configuration->getConfig();
			$theme = $config->website_theme;
			Cache::put('theme', $theme, 60);
//		}
		
		/**
		 * Setting Theme path.
		 */
		if($theme == 'betube_light' || $theme == 'betube_dark' ) {
			$finder = new \Illuminate\View\FileViewFinder(app()['files'], array(resource_path('views/themes/betube')));
			\View::setFinder($finder);
		}
		return $next($request);
	}
}
