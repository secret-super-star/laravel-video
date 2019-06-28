<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'apiAuth', 'namespace' => 'API'],function (){

	/*Finalized Routes*/
	Route::post('saveToken', 'PushNotificationController@saveToken');

	Route::post('getCategoriesAndTags', [
		'as' => 'getCategoriesAndTags',
		'uses' => 'CategoryController@getCategoriesAndTags'
	]);

	Route::post('video/homeScreen', [
		'as' => 'homeScreen',
		'uses' => 'VideoController@homeScreen'
	]);

	Route::post('category/getCategoriesVideos', [
		'as' => 'getCategoriesVideos',
		'uses' => 'CategoryController@getCategoriesVideos'
	]);

	Route::post('tag/getTagsVideos', [
		'as' => 'getTagsVideos',
		'uses' => 'TagsController@getTagsVideos'
	]);

	Route::post('video/getVideo', [
		'as' => 'getVideo',
		'uses' => 'VideoController@getVideo'
	]);

	Route::post('celebrity/list', [
		'as' => 'celebrities',
		'uses' => 'CelebritiesController@getCelebrities'
	]);

	Route::post('celebrity/{id}', [
		'as' => 'celebrities',
		'uses' => 'CelebritiesController@getCelebrityDetail'
	]);

	Route::post('celebrity/video/{id}', [
		'as' => 'celebrities',
		'uses' => 'CelebritiesController@getCelebrityVideoDetail'
	]);

	Route::post('celebrity/albums/{id}', [
		'as' => 'celebrities',
		'uses' => 'CelebritiesController@getCelebrityAlbumsDetail'
	]);

	Route::post('albums/{id}/detail', [
		'as' => 'celebrities',
		'uses' => 'CelebritiesController@getAlbumsDetail'
	]);
	
  Route::post('video/videoView', [
		'as' => 'videoView',
		'uses' => 'VideoController@videoView'
	]);
	/*Finalized Routes*/

//  //TODO: REMOVE BELOW ROUTES AFTER NOV 12 2017
//	// TODO:
//	// Use auth:api middleware for all kind of login related informatiion
//	Route::post('login', 'UserController@login');
//	Route::post('register', 'UserController@register');
//
//	Route::post('subcategories/{id?}', [
//		'as' => 'subcategories',
//		'uses' => 'CategoryController@getCategories'
//	]);
//
//	Route::post('details', 'UserController@details');
//
//	//	All the Category Related Routes are Written Here
//	Route::group(['prefix' => 'category'], function () {
//
//		Route::post('getCategories', [
//			'as' => 'getCategories',
//			'uses' => 'CategoryController@getCategories'
//		]);
//
//	});
//
//	//	All the Tags Related Routes are Written Here
//	Route::group(['prefix' => 'tag'], function () {
//
//		Route::post('getTags', [
//			'as' => 'getTags',
//			'uses' => 'TagsController@getTags'
//		]);
//
//	});
//
//	//	All the Tags Related Routes are Written Here
//	Route::group(['prefix' => 'video'], function () {
//
//		Route::post('getTags', [
//			'as' => 'getTags',
//			'uses' => 'TagsController@getTags'
//		]);
//
//		Route::post('getTagsVideos', [
//			'as' => 'getTagsVideos',
//			'uses' => 'TagsController@getTagsVideos'
//		]);
//
//
//		Route::post('videoView', [
//			'as' => 'videoView',
//			'uses' => 'VideoController@videoView'
//		]);
//
//	});
//
//	Route::group(['prefix' => 'user'], function () {
//
//		Route::post('reset', [
//			'as' => 'reset',
//			'uses' => 'UserController@reset'
//		]);
//
//	});
//
	Route::group(['prefix' => 'notification'], function () {
		Route::post('sendNotification', [
			'as' => 'sendNotification',
			'uses' => 'PushNotificationController@sendNotification'
		]);
	});
//
	Route::group(['prefix' => 'celebrities'], function () {

		Route::post('getCelebrityDetail', [
			'as' => 'getCelebrityDetail',
			'uses' => 'CelebritiesController@getCelebrityVideos'
		]);

	});

	Route::post('getPlaces', [
		'as' => 'getPlaces',
		'uses' => 'PlacesController@getPlaces'
	]);

	Route::get('search/video', [
		'as' => 'getPlaces',
		'uses' => 'VideoController@searchVideo'
	]);

	Route::get('validate/series', [
		'as' => 'validateVideos',
		'uses' => 'VideoController@validateVideo'
	]);

});
