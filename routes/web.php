<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sitemap', [
    'as'    => 'sitemap',
    'uses'  => 'SitemapController@sitemap',
    'title' => 'Sitemap'
]);

Route::get('/openload', function (){
	return view('openload');
});

Route::get('/sendPush',[
	'as'    => 'sendPush',
	'uses'  => 'IndexController@sendPush',
]);

Route::get('/test',[
	'as'    => 'sendPush',
	'uses'  => 'Admin\VideoGroupsController@createVGImage',
]);

Route::get('/box-image/{id}.jpg',[
	'as'    => 'box-image',
	'uses'  => 'Admin\VideoController@getBoxImage',
]);

/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth'], function () {
	
	// Authentication Routes...
	Route::get('login', 'LoginController@showLoginForm')->name('login');
	Route::post('login', 'LoginController@login');
	Route::get('logout', 'LoginController@logout')->name('logout');
	
	// Registration Routes...
	if (config('auth.users.registration')) {
		Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
		Route::post('register', 'RegisterController@register');
	}
	
	// Password Reset Routes...
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'ResetPasswordController@reset');
	
	// Confirmation Routes...
	if (config('auth.users.confirm_email')) {
		Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
		Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
	}
	
	// Social Authentication Routes...
	Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
	Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});


	
Route::domain('up.tfc5.com')->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
		Route::post('videos/updateVideo',[
				'as'    => 'up.updateVideo',
				'uses'  => 'VideoController@updateVideo',
			]);
    });
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
	
	/**
	 * Dashboard Routes
	 * */
	Route::get('/', 'DashboardController@index')->name('dashboard');
	
	/**
	 * Users Routes
	 * */
	Route::get('users', 'UserController@index')->name('users');
	Route::get('users/{user}', 'UserController@show')->name('users.show');
	Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
	Route::put('users/{user}', 'UserController@update')->name('users.update');
	Route::get('deleteUser/{user}', 'UserController@destroy')->name('users.destroy');

	/**
	 * Categories Routes
	 * */
	Route::get('/categories',[
		'as'    => 'categories',
		'uses'  => 'CategoryController@index',
	]);
	
	Route::get('/new/categories',[
		'as'    => 'categories',
		'uses'  => 'CategoryController@addCategory',
	]);
	
	Route::post('/categories/addCategories',[
		'as'    => 'categories',
		'uses'  => 'CategoryController@postAddCategories',
	]);
	
	Route::get('categories/{category}',[
		'as'    => 'getCategories',
		'uses'  => 'CategoryController@getCategory',
	]);
	
	Route::get('subcategories/{category}',[
		'as'    => 'getCategories',
		'uses'  => 'CategoryController@getSubCategory',
	]);
	
	Route::post('subcategories/{category}',[
		'as'    => 'getCategories',
		'uses'  => 'CategoryController@getSubCategory',
	]);
	
	Route::post('categories/updateCategories',[
		'as'    => 'updateCategories',
		'uses'  => 'CategoryController@updateCategories',
	]);
	
	Route::get('category/{catiId}',[
		'as'    => 'updateCategories',
		'uses'  => 'CategoryController@deleteCategories',
	]);
	
	Route::post('categories/updateCustomOrder',[
		'as'    => 'updateCustomOrder',
		'uses'  => 'CategoryController@updateCustomOrder',
	]);
	
	
	/**
	 * Tags Routes
	 * */
	Route::get('/tags',[
		'as'    => 'tags',
		'uses'  => 'TagsController@index',
	]);
	
	Route::get('/new/tags',[
		'as'    => 'tags',
		'uses'  => 'TagsController@addTags',
	]);
	
	Route::post('/tags/addTags',[
		'as'    => 'addTags',
		'uses'  => 'TagsController@postAddTags',
	]);
	
	Route::get('tags/{tag}',[
		'as'    => 'getTag',
		'uses'  => 'TagsController@getCategory',
	]);
	
	Route::post('tags/updateTags',[
		'as'    => 'updateTags',
		'uses'  => 'TagsController@updateTags',
	]);
	
	Route::get('tag/{catiId}',[
		'as'    => 'updateTags',
		'uses'  => 'TagsController@deleteTags',
	]);
	
	/**
	 * Server Routes
	 * */
	Route::get('/servers',[
		'as'    => 'servers',
		'uses'  => 'ServerController@index',
	]);
	
	Route::get('/new/server',[
		'as'    => 'newServers',
		'uses'  => 'ServerController@addServer',
	]);
	
	Route::post('/servers/addServer',[
		'as'    => 'addServers',
		'uses'  => 'ServerController@postAddServer',
	]);
	
	Route::get('servers/{server}',[
		'as'    => 'getServer',
		'uses'  => 'ServerController@getServer',
	]);
	
	Route::post('servers/updateServers',[
		'as'    => 'updateServers',
		'uses'  => 'ServerController@updateServer',
	]);
	
	Route::get('server/{serverId}',[
		'as'    => 'updateServers',
		'uses'  => 'ServerController@deleteServers',
	]);
	
	/**
	 * Video Routes
	 * */
	Route::get('/videos',[
		'as'    => 'index',
		'uses'  => 'VideoController@index',
	]);
	
	Route::get('/new/video',[
		'as'    => 'addVideo',
		'uses'  => 'VideoController@addVideo',
	]);
	
	 Route::post('/new/video/get-data',[
	  'as'    => 'get_data_video_source',
	  'uses'  => 'VideoController@getDataVideoSource',
	 ]);
	
	Route::get('/video/box-image/{id}.jpg',[
		'as'    => 'box-image',
		'uses'  => 'VideoController@getBoxImage',
	]);

	Route::post('/videos/addVideo',[
		'as'    => 'postAddVideo',
		'uses'  => 'VideoController@postAddVideo',
	]);
	
	Route::post('/videos/addVideo/multiple',[
		'as'    => 'postAddVideo',
		'uses'  => 'VideoController@postAddVideoMultiple',
	]);
	
	Route::get('videos/{video}',[
		'as'    => 'getVideo',
		'uses'  => 'VideoController@getVideo',
	]);
	
	Route::post('videos/updateVideo',[
		'as'    => 'updateVideo',
		'uses'  => 'VideoController@updateVideo',
	]);
	
	Route::post('videos/updateVideo/multiple',[
		'as'    => 'updateVideo',
		'uses'  => 'VideoController@updateVideoMultiple',
	]);
	
	Route::get('video/{videoID}',[
		'as'    => 'deleteVideo',
		'uses'  => 'VideoController@deleteVideo',
	]);
	
	Route::get('removeSeriesVideo/{videoID}',[
		'as'    => 'deleteVideo',
		'uses'  => 'VideoController@removeSeriesVideo',
	]);
	
	Route::get('adds',[
		'as'    => 'adds',
		'uses'  => 'VideoController@adds',
	]);
	
	Route::post('adds',[
		'as'    => 'adds',
		'uses'  => 'VideoController@PostAdds',
	]);
	
	Route::get('recheckSFTP',[
		'as'    => 'adds',
		'uses'  => 'ServerController@getCheckSFTPConnections',
	]);
	
	
	/**
	 * Website configuration routes
	 * */
	Route::get('website-configuration',[
		'as'    => 'websiteConfiguration',
		'uses'  => 'ConfigController@websiteConfiguration',
	]);
	
	Route::post('websiteConfiguration',[
		'as'    => 'websiteConfiguration',
		'uses'  => 'ConfigController@configureWebsite',
	]);
	
	Route::get('privacy-policy',[
		'as'    => 'privacyPolicy',
		'uses'  => 'ConfigController@privacyPolicy',
	]);
	
	Route::post('postCreatePrivacyPolicy',[
		'as'    => 'privacyPolicy',
		'uses'  => 'ConfigController@postPrivacyPolicy',
	]);
	
	Route::get('terms-conditions',[
		'as'    => 'privacyPolicy',
		'uses'  => 'ConfigController@TOS',
	]);
	
	Route::post('postTermsConditions',[
		'as'    => 'websiteConfiguration',
		'uses'  => 'ConfigController@postTOS',
	]);
	
	Route::get('combination-images',[
		'as'    => 'combinationImages',
		'uses'  => 'CombinationController@index',
	]);
	
	Route::get('/new/combination-images',[
		'as'    => 'createCombinationForm',
		'uses'  => 'CombinationController@show',
	]);
	
	Route::get('/combination-images/{id}',[
		'as'    => 'createCombinationForm',
		'uses'  => 'CombinationController@edit',
	]);
	
	Route::post('/combination-images/{id}',[
		'as'    => 'createCombinationForm',
		'uses'  => 'CombinationController@update',
	]);
	
	Route::post('/new/combination-images',[
		'as'    => 'createCombinationForm',
		'uses'  => 'CombinationController@create',
	]);
	
	Route::get('mass-emails',[
		'as'    => 'massEmails',
		'uses'  => 'MassEmailsController@index',
	]);
	
	Route::post('postMassEmail',[
		'as'    => 'postMassEmail',
		'uses'  => 'MassEmailsController@postMassEmail',
	]);

	Route::get('modules',[
		'as'    => 'modules',
		'uses'  => 'ModulesController@index',
	]);

	Route::post('setupModules',[
		'as'    => 'setupModules',
		'uses'  => 'ModulesController@setupModules',
	]);
	
	/**
	 * Celebrity routes
	 * */
	Route::group(['middleware' => 'ModulesRequest'], function () {
		Route::get('celebrities',[
			'as'    => 'celebrities',
			'uses'  => 'CelebritiesController@index',
			'module' => 'celebrity_module'
		]);

		Route::get('new/celebrity',[
			'as'    => 'celebrities',
			'uses'  => 'CelebritiesController@createCelebrity',
			'module' => 'celebrity_module'
		]);

		Route::post('new/celebrity',[
			'as'    => 'celebrities',
			'uses'  => 'CelebritiesController@postCreateCelebrity',
			'module' => 'celebrity_module'
		]);

		Route::get('edit/{celebrityName}',[
			'as'    => 'celebrities',
			'uses'  => 'CelebritiesController@EditCreateCelebrity',
			'module' => 'celebrity_module'
		]);

		Route::post('edit/celebrity',[
			'as'    => 'celebrities',
			'uses'  => 'CelebritiesController@postEditCreateCelebrity',
			'module' => 'celebrity_module'
		]);

		Route::get('celebrity/delete/{id}',[
			'as'    => 'celebrities',
			'uses'  => 'CelebritiesController@deleteCelebrity',
			'module' => 'celebrity_module'
		]);
	});
	
	/**
	 * Notification routes
	 * */
	Route::get('notification',[
		'as'    => 'notification',
		'uses'  => 'PushNotificationController@index',
	]);
	
	Route::get('sendNotification',[
		'as'    => 'sendNotification',
		'uses'  => 'PushNotificationController@sendNotification',
	]);
	
	
	/**
	 * Celebrity Album routes
	 */
	Route::group(['middleware' => 'ModulesRequest'], function () {
		Route::get('celebrity/album',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CelebritiesController@celebrityAlbum',
			'module' => 'celebrity_module'
		]);

		Route::get('celebrity/album/{name}',[
			'as'    => 'editCelebrityAlbum',
			'uses'  => 'CelebritiesController@editCelebrityAlbum',
			'module' => 'celebrity_module'
		]);

		Route::get('celebrity/deleteAlbum/{id}',[
			'as'    => 'editCelebrityAlbum',
			'uses'  => 'CelebritiesController@deleteCelebrityAlbum',
			'module' => 'celebrity_module'
		]);

		Route::get('celebrity/new/album',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CelebritiesController@newCelebrityAlbum',
			'module' => 'celebrity_module'
		]);

		Route::post('celebrity/postCelebrityAlbum',[
			'as'    => 'postCelebrityAlbum',
			'uses'  => 'CelebritiesController@postCelebrityAlbum',
			'module' => 'celebrity_module'
		]);

		Route::post('celebrity/postEditCelebrityAlbum',[
			'as'    => 'postEditCelebrityAlbum',
			'uses'  => 'CelebritiesController@postEditCelebrityAlbum',
			'module' => 'celebrity_module'
		]);
	});

	
	/**
	 * Cities Crud
	 * */
	Route::group(['middleware' => 'ModulesRequest'], function () {

		Route::get('cities',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CitiesController@index',
			'module' => 'video_groups_module'
		]);

		Route::get('cities/{cityId}',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CitiesController@edit',
			'module' => 'video_groups_module'
		]);

		Route::get('new/city',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CitiesController@add',
			'module' => 'video_groups_module'
		]);

		Route::post('cities/newCity',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CitiesController@store',
			'module' => 'video_groups_module'
		]);

		Route::post('cities/updateCity/{id}',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CitiesController@update',
			'module' => 'video_groups_module'
		]);

		Route::get('cities/delete/{id}',[
			'as'    => 'celebrityAlbum',
			'uses'  => 'CitiesController@destroy',
			'module' => 'video_groups_module'
		]);
	});
	
	/**
	 * Places Crud
	 * */
	Route::get('places/{id?}',[
		'as'    => 'celebrityAlbum',
		'uses'  => 'PlacesController@index',
	]);
	
	Route::get('places/edit/{placeId}',[
		'as'    => 'celebrityAlbum',
		'uses'  => 'PlacesController@edit',
	]);
	
	Route::get('new/place',[
		'as'    => 'celebrityAlbum',
		'uses'  => 'PlacesController@add',
	]);
	
	Route::post('places/newPlace',[
		'as'    => 'celebrityAlbum',
		'uses'  => 'PlacesController@store',
	]);

	Route::get('places/delete/{id}',[
		'as'    => 'celebrityAlbum',
		'uses'  => 'PlacesController@destroy',
	]);

	Route::post('places/updatePlace/{id}',[
		'as'    => 'celebrityAlbum',
		'uses'  => 'PlacesController@update',
	]);

	
	/**
	 * Video Groups
	 * */
	Route::group(['middleware' => 'ModulesRequest'], function () {
		Route::get('video-groups',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupsController@index',
			'module' => 'video_groups_module'
		]);

		Route::get('video-groups/{id}',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupsController@edit',
			'module' => 'video_groups_module'
		]);

		Route::get('new/video-groups/',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupsController@create',
			'module' => 'video_groups_module'
		]);

		Route::post('new/video-groups/',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupsController@store',
			'module' => 'video_groups_module'
		]);

		Route::post('edit/video-groups/{id}',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupsController@update',
			'module' => 'video_groups_module'
		]);

		Route::get('delete/video-groups/{id}',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupsController@delete',
			'module' => 'video_groups_module'
		]);
	});

	/**
	 * Video Groups Categories
	 * */
	Route::group(['middleware' => 'ModulesRequest'], function () {

	    Route::get('video-group-categories',[
			'as'    => 'videoGroupCategories',
			'uses'  => 'VideoGroupCategoriesController@index',
			'module' => 'video_groups_module'
		]);

		Route::get('new/video-group-categories',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupCategoriesController@create',
			'module' => 'video_groups_module'
		]);

		Route::post('new/video-group-categories',[
			'as'    => 'videoGroups',
			'uses'  => 'VideoGroupCategoriesController@createPost',
			'module' => 'video_groups_module'
		]);

        Route::get('video-group-categories/{id}',[
            'as'    => 'videoGroups',
            'uses'  => 'VideoGroupCategoriesController@edit',
            'module' => 'video_groups_module'
        ]);

        Route::post('video-group-categories/{id}',[
            'as'    => 'videoGroups',
            'uses'  => 'VideoGroupCategoriesController@editPost',
            'module' => 'video_groups_module'
        ]);

        Route::get('delete/video-group-categories/{id}',[
            'as'    => 'videoGroups',
            'uses'  => 'VideoGroupCategoriesController@deletePost',
            'module' => 'video_groups_module'
        ]);

	});
	
});



/**
 * Client End routes
 */

Route::group(['middleware' => 'theme'], function () {
	
	Route::get('filterSeries', [
		'as' => 'filterSeries',
		'uses' => 'IndexController@filterSeries',
	]);
	
	Route::get('/', [
		'as' => 'root',
		'uses' => 'IndexController@index',
		'title' => 'Home'
	]);
	
	Route::get('category/{category}', [
		'as' => 'categoryVideos',
		'uses' => 'IndexController@categoryVideos',
		'title' => 'Category Videos'
	]);
	
	Route::group(['middleware' => 'ModulesRequest'], function () {
		Route::get('groups', [
			'as' => 'categoryVideos',
			'uses' => 'IndexController@groups',
			'title' => 'Group Videos',
			'module' => 'video_groups_module'
		]);
		
		Route::get('groups/category/{category}', [
			'as' => 'categoryVideos',
			'uses' => 'IndexController@groupsCategories',
			'title' => 'Group Videos',
			'module' => 'video_groups_module'
		]);
		
		Route::get('groups/{groupName}', [
			'as' => 'categoryVideos',
			'uses' => 'IndexController@groupVideos',
			'title' => 'Group Videos',
			'module' => 'video_groups_module'
		]);
	});
	
	Route::get('tags/{tag}', [
		'as' => 'tagVideos',
		'uses' => 'IndexController@tagVideos',
		'title' => 'Tags Videos'
	]);
	
	Route::get('seriesVideos', [
		'as' => 'seriesVideos',
		'uses' => 'IndexController@seriesVideos',
		'title' => 'Series Videos'
	]);
	
	Route::get('seriesVideos/getDL/{path}.m3u8', [
		'as' => 'seriesVideosDailymotion',
		'uses' => 'IndexController@seriesVideosDailymotion',
		'title' => 'Series Videos'
	]);
	
	Route::get('/album/{albumName}', [
		'as' => 'albumDetail',
		'uses' => 'IndexController@albumDetail',
		'title' => 'Celebrity Profile'
	]);
	
	Route::group(['middleware' => 'ModulesRequest'], function () {
		Route::get('reciter/{celebrityName}', [
			'as' => 'celebrityDetailPage',
			'uses' => 'IndexController@celebrityPage',
			'title' => 'Celebrity Profile',
			'module' => 'celebrity_module'
		]);
		
		Route::get('/celebrities', [
			'as' => 'reciters',
			'uses' => 'IndexController@celebrities',
			'title' => 'All Reciters',
			'module' => 'celebrity_module'
		]);
	});
	
	Route::get('user/{userName}', [
		'as' => 'celebrityPage',
		'uses' => 'IndexController@usersDetail',
		'title' => 'User Profile'
	]);
	
	Route::group(['middleware' => 'ModulesRequest'], function () {
		Route::get('/city/{name}', [
			'as' => 'cities',
			'uses' => 'IndexController@citiesPlaces',
			'title' => 'All Cities',
			'module' => 'video_groups_module'
		]);
		
		Route::get('/cities', [
			'as' => 'cities',
			'uses' => 'IndexController@cities',
			'title' => 'All Cities',
			'module' => 'video_groups_module'
		]);
	});
	
	Route::get('/{seriesName}/{seriesId}', [
		'as' => 'seriesVideos',
		'uses' => 'IndexController@seriesVideos',
	]);
	
	Route::get('/watch', [
		'as' => 'watch',
		'uses' => 'IndexController@videos',
		'title' => 'All Videos'
	]);
	
	Route::get('/users', [
		'as' => 'watch',
		'uses' => 'IndexController@users',
		'title' => 'All Users'
	]);
	
	Route::get('/categories', [
		'as' => 'watch',
		'uses' => 'IndexController@categories',
		'title' => 'All Categories'
	]);

	// Route::get('/categories', function(){
	    // return redirect('404');
    // });

	Route::get('/category', function(){
	    return redirect('404');
    });
	
	Route::get('/terms', [
		'as' => 'terms',
		'uses' => 'IndexController@terms',
		'title' => 'Terms'
	]);
	
	Route::get('/privacy', [
		'as' => 'privacy',
		'uses' => 'IndexController@privacy',
		'title' => 'Privacy'
	]);
	
	Route::get('/404', function () {
		return view('404');
	});
	
	Route::group(['middleware' => 'auth'], function () {
		
		Route::get('/dashboard', [
			'as' => 'dashboard',
			'uses' => 'DashboardController@index',
			'title' => 'Dashboard'
		]);
		
		Route::post('/updateRecord', [
			'as' => 'updateRecord',
			'uses' => 'DashboardController@updateRecord',
			'title' => 'Dashboard'
		]);
		
		Route::post('/likeVideo', [
			'as' => 'likeVideo',
			'uses' => 'DashboardController@likeVideo',
			'title' => 'likeVideo'
		]);
		
	});
	
});