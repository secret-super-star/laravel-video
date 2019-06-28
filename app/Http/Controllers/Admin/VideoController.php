<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\VideoRequest;
use App\Models\Adds;
use App\Models\Albums;
use App\Models\Categories;
use App\Models\Celebrities;
use App\Models\CelebrityAlbum;
use App\Models\SeriesVideos;
use App\Models\Servers;
use App\Models\Tags;
use App\Models\VideoCategories;
use App\Models\VideoCelebrities;
use App\Models\VideoGroups;
use App\Models\VideoGroupsSeries;
use App\Models\VideoTags;
use App\Models\websiteConfiguration;
use App\Services\GeneralServices;
use Carbon\Carbon, Storage, Cache;
use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\Series;

class VideoController extends Controller
{
	
	function __construct()
	{
		$this->services = new GeneralServices();
		$this->series = new Series();
		$this->seriesVideos = new SeriesVideos();
		$this->categories = new Categories();
		$this->tags = new Tags();
		$this->videoCategories= new VideoCategories();
		$this->videoTags= new VideoTags();
		$this->adds= new Adds();
		$this->servers = new Servers();
		$this->celebrities = new Celebrities();
		$this->videoCelebrities = new VideoCelebrities();
		$this->config = new websiteConfiguration();
		$this->albums = new Albums();
		$this->celebrityAlbum = new CelebrityAlbum();
		$this->videoGroupsSeries = new VideoGroupsSeries();
	}
	
	public function index(Request $request)
	{
		return view('admin.videos.index',[
			'series' => isset($request->featured) && isset($request->featured)  > 0 ? $this->series->getFeaturedSeries() :  $this->series->getAllSeries(false, false, 20)
		]);
	}
	
	public function getBoxImage($id = null) {
		if (!empty($id))
		{
			$token = Common::getBoxToken();

			if ($token !== false)
			{
				$image = Common::cURL('https://api.box.com/2.0/files/' . $id . '/thumbnail.jpg?min_height=320&min_width=320&max_height=320&max_width=320', false, false, ['Authorization: Bearer ' . $token]);

				return response($image, 200)
                  ->header('Content-Type', 'image/jpeg');
			}
		}
	}
	
	public function saveBoxImage($id = null, $nextId) {
		if (!empty($id))
		{
			// $key = "box-access_token-$id";
			
			// if (Cache::has($key))
			// {
				// $access_token = Cache::get($key);
			// } else {
				// $box_config = config('services.box');
				
				// $data = [
					// 'grant_type' => 'refresh_token',
					// 'refresh_token' => $box_config['refresh_token'],
					// 'client_id' => $box_config['client_id'],
					// 'client_secret' => $box_config['client_secret'],
				// ];

				// $response = Common::cURL('https://api.box.com/oauth2/token', false, http_build_query($data));

				// $response = json_decode($response, 1);

				// if (isset($response['access_token']))
				// {
					// $access_token = $response['access_token'];
					// Cache::put($key, $access_token, 60);
				// }
			// }
			
			// if (isset($access_token))
			// {
				// $image = Common::cURL('https://api.box.com/2.0/files/' . $id . '/thumbnail.jpg?min_height=320&min_width=320&max_height=320&max_width=320', false, false, ['Authorization: Bearer ' . $access_token]);
				
				// $dt = Carbon::parse(Carbon::Now());
                // $timeStamp = $dt->timestamp;

				// $file_name = 'video_series_' . $nextId. '_' . $timeStamp . '.jpg';
				// Storage::disk('thumbs_3rd')->put($file_name, $image);
				// $date = \Carbon\Carbon::now();
				// return '/thumbs_3rd'.'/'.$date->year.'/'.$date->month.'/'.$date->day.'/'. $file_name;
			// }
			
			$token = Common::getBoxToken();

			if ($token !== false)
			{
				$image = Common::cURL('https://api.box.com/2.0/files/' . $id . '/thumbnail.jpg?min_height=320&min_width=320&max_height=320&max_width=320', false, false, ['Authorization: Bearer ' . $token]);

				
				$date = \Carbon\Carbon::now();
				$date->setTimezone('UTC');
				
				$dt = Carbon::parse($date);
				
                $timeStamp = $dt->timestamp;

				$file_name = 'video_series_' . $nextId. '_' . $timeStamp . '.jpg';
				Storage::disk('thumbs_3rd')->put($file_name, $image);
				
				return '/thumbs_3rd'.'/'.$date->year.'/'.$date->month.'/'.$date->day.'/'. $file_name;
			}
		}
	}
	
	public function addVideo(Request $request)
	{
		return view('admin.videos.add',[
			'videos' => array(),
			'categories' => $this->categories->getCategories(false, true),
			'tags' => $this->tags->get(),
			'celebrities' =>$this->celebrities->getAllCelebrities(),
			'config' => $this->config->first()
		]);
	}
	
	private function save3rdThumb($thumb, $nextId)
	{
		if ($thumb !== '')
		{			
			$thumb_content = Common::cURL($thumb);
			
			if ($thumb_content !== '')
			{
				$tmp = explode('?', $thumb);
				
				$ext = pathinfo($tmp[0], PATHINFO_EXTENSION);

                $date = \Carbon\Carbon::now();
				$date->setTimezone('UTC');
				
				$dt = Carbon::parse($date);
				
                $timeStamp = $dt->timestamp;

				$file_name = 'video_series_' . $nextId. '_' . $timeStamp . '.' . (empty($ext) ? 'jpg' : $ext);
				Storage::disk('thumbs_3rd')->put($file_name, $thumb_content);

				return '/thumbs_3rd'.'/'.$date->year.'/'.$date->month.'/'.$date->day.'/'. $file_name;
			}
		}

		return '';
	}
	
	public function getDataVideoSource(Request $request)
	{
		if ($request->has('source_3rd') && filter_var($request->get('source_3rd'), FILTER_VALIDATE_URL))
		{
			$link = $request->get('source_3rd');
			
			$nextId = $request->get('sid');
			
			if ($nextId == 'new')
			{
				$data = DB::select("SHOW TABLE STATUS LIKE 'series'");

				$data = array_map(function ($value) {
					return (array)$value;
				}, $data);

				$nextId = $data[0]['Auto_increment'];
			}

			if (preg_match('#(player\.)?vimeo\.com(/video)?/(\d+)#i', $link, $match))
			{
				$id = $match[3];
				$vimeo = Common::cURL("https://player.vimeo.com/video/$id/config");					
				
				$vimeo = json_decode($vimeo, 1);

				if (isset($vimeo['video']))
				{
					$title = isset($vimeo['video']['title']) ? $vimeo['video']['title'] : '';
					
					$original_thumb = isset($vimeo['video']['thumbs'][640]) ? $vimeo['video']['thumbs'][640] : '';
					$duration = isset($vimeo['video']['duration']) ? intval($vimeo['video']['duration']) : 0;
					
					$thumb = $this->save3rdThumb($original_thumb, $nextId);
				}
			}
			 elseif (strpos($link, 'dailymotion.com') !== false) 
			{
				$dailymotion = Common::cURL($link);	
				
				if (preg_match('#var config = \{(.*?)\};#is', $dailymotion, $match) || preg_match('#var __PLAYER_CONFIG__ = \{(.*?)\};#is', $dailymotion, $match))
				{
					$config = json_decode('{' . $match[1] . '}', 1);
				
					if (isset($config['metadata']))
					{
						$title = isset($config['metadata']['title']) ? $config['metadata']['title'] : '';
						
						$original_thumb = isset($config['metadata']['poster_url']) ? $config['metadata']['poster_url'] : '';
						$duration = isset($config['metadata']['duration']) ? intval($config['metadata']['duration']) : 0;
						
						$thumb = $this->save3rdThumb($original_thumb, $nextId);
					}
				}
			} elseif (strpos($link, 'vid.me') !== false) 
			{
				$vidme = Common::cURL('https://api.vid.me/videoByUrl?url=' . urlencode($link));
				
				$vidme = json_decode($vidme, 1);
	
				if (isset($vidme['video']))
				{
					$title = isset($vidme['video']['title']) ? $vidme['video']['title'] : '';
					
					$original_thumb = '';
					
					if (isset($vidme['video']['thumbnail_url']))
					{
						$tmp = explode('?', $vidme['video']['thumbnail_url']);
						$original_thumb = $tmp[0];
					}

					$duration = isset($vidme['video']['duration']) ? intval($vidme['video']['duration']) : 0;
					
					$thumb = $this->save3rdThumb($original_thumb, $nextId);
				}
			} elseif (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match)) 
			{
				$content = Common::cURL('https://youtube.com/get_video_info?el=vevo&fmt=18&asv=2&hd=1&video_id=' . $match[1]);
				
				if (!empty($content))
				{
					parse_str($content, $youtube);
					
					$title = isset($youtube['title']) ? $youtube['title'] : '';
					$duration = isset($youtube['length_seconds']) ? $youtube['length_seconds'] : '';
						
					$thumb = isset($youtube['iurlmq']) ? $youtube['iurlmq'] : (isset($youtube['iurl']) ? $youtube['iurl'] : '');
					$original_thumb = isset($youtube['iurlhq720']) ? $youtube['iurlhq720'] : (isset($youtube['iurlhq']) ? $youtube['iurlhq'] : '');

					$thumb = $this->save3rdThumb($thumb, $nextId);
				}
			} elseif (strpos($link, 'facebook') !== false && preg_match("~/videos/(?:t\.\d+/)?(\d+)~i", $link, $match)) 
			{
				$id = $match[1];
				
				$token = 'EAAQ6g8qY5WYBAEHZCu3E9aw0CQxYzbk0ye0eXdqO1KD5HrUNvlsJymFgABf5ljnX28j9BtPgJ0X0oXB2p0D3RgF74ZBQZBLlojZCoRBdidCl6Wco2bsZAvV7k4Ha0mNgrwPlK3RKuo33A742Wbf41EFOPIUTsVTonpwk6Ht3lngZDZD';
				
				$fb_video = Common::cURL("https://graph.facebook.com/$id?fields=length,picture,title&access_token=$token");
			
				$fb_video = json_decode($fb_video, 1);

				if (!empty($fb_video) && isset($fb_video['length']))
				{
					$title = isset($fb_video['title']) ? $fb_video['title'] : '';
					$thumb = isset($fb_video['picture']) ? $fb_video['picture'] : '';
					$original_thumb = $thumb;
					$duration = isset($fb_video['length']) ? intval($fb_video['length']) : 0;
					
					$thumb = $this->save3rdThumb($thumb, $nextId);
					
					$fb_video_embed = Common::cURL("https://www.facebook.com/video/embed?video_id=$id");
					
					if (!empty($fb_video_embed) && preg_match('#img" src="(.*?)"#is', $fb_video_embed, $img))
					{
						$original_thumb = htmlspecialchars_decode($img[1]);
					}
				}
			} elseif (strpos($link, 'box.com') !== false) 
			{
				$box = Common::cURL($link);
				
				if (preg_match('#"itemID":(.*?),"#is', $box, $match))
				{
					$file_id = $match[1];
					
					$title = '';
					
					$token = Common::getBoxToken();

					if ($token !== false)
					{
						$file = Common::cURL('https://api.box.com/2.0/files/' . $file_id, false, false, ['Authorization: Bearer ' . $token]);
						
						$file = json_decode($file, 1);
						
						if (isset($file['name']))
						{
							$title = str_replace(['.mp4', '.MP4'], '', $file['name']);
						}
					}
					
					$original_thumb = route('admin.box-image', ['id' => $file_id]);
					
					$duration = 0;
					
					$thumb = $this->saveBoxImage($file_id, $nextId);
				}
			} elseif (strpos($link, 'yadi.sk') !== false) 
			{
				$yadisk = Common::cURL($link);
				
				$title = $thumb = $original_thumb = '';
				$duration = 0;
				
				if (preg_match('#property="og:image" content="(.*?)"#is', $yadisk, $match))
				{
					$img_link = htmlspecialchars_decode($match[1]);
					$img_link = str_replace(['crop=1', 'logo=1'], ['crop=0', 'logo=0'], $img_link);
					
					parse_str($img_link, $arr);
					
					$title = str_replace(['.mp4', '.MP4'], '', $arr['filename']);
					
					$original_thumb = str_replace($arr['size'], '480x360', $img_link);

					$thumb = $this->save3rdThumb($original_thumb, $nextId);
					
					$original_thumb = '';
				}
			}
		}
		
		$result = [
			'success' => false
		];
		
		if (isset($duration))
		{
			$result = [
				'success' => true,
				'title' => $title,
				'original_thumb' => $original_thumb,
				'thumb' => $thumb,
				'duration' => $duration,
			];
		}
		
		return response()->json($result);
	}
	
	public function postAddVideoMultiple(Request $request)
	{
//		dd($request->all());
		DB::transaction(function () use ($request) {
			$request['thumbnailImage'] = isset($request->mythumbnail) ? $request->mythumbnail : false;
			
			$series = $this->series->createSeries($request);
			$categories = $this->videoCategories->create([
				'series_id' => $series->id,
				'category_id' => $request->category,
				'sub_category_id' => $request->subcategory,
			]);
			
			foreach ($request->tags as $val) {
				$this->videoTags->create([
					'series_id' => $series->id,
					'tag_id' => $val,
				]);
			}
			
			$request->celebrities = $request->celebrities == null ? array() : $request->celebrities;
			foreach ($request->celebrities as $val) {
				$this->videoCelebrities->create([
					'series_id' => $series->id,
					'celebrities_id' => $val,
				]);
			}
			for ($z=1; $z <4; $z++) {
				
				for ($i = 0; $i < count($request['sourceType'.$z]); $i++) {
					if ((int)$request['sourceType'.$z][$i] == 1) {
						
						try {

//							dump('--==');
//							dump($i);
//							dump($request['textSource'.$z]);
//							dump('--==');
							
						$this->seriesVideos->createSeriesVideos(
							$series->id, 
							$request['textSource'.$z][$i], 
							1, 
							'',
							 '', 
							 $z
							);
						} catch (\Exception $e) {
//							dump('--------');
//							dump([$i]);
//							dump('--------');
//							dump($request['textSource'.$z]);
//							dd('p');
						}
					} else {
						// $file = $request['uploadFile'.$z][$i];
						// $extension = $file->getClientOriginalExtension();
						// $originalName = $file->getClientOriginalName();
						// $fileOriginalName = $file->getClientOriginalName();
						// $fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						// $dt = Carbon::parse(Carbon::Now());
						// $timeStamp = $dt->timestamp;
						// $filename = $timeStamp . '.' . $extension; //. '__' . $fileOriginalName . 
						// $upload_success = $file->move(public_path() . '/uploads', $filename);
						// $fName = asset('uploads/' . $filename);
						// $server = $this->services->getLowerTrafficServer();
						// if (count($server['data']) > 0) {
							// $fName = public_path('uploads') . '/' . $filename;
							// $status = self::uploadSFTPVideo($server['data'], $fName, $filename);
							// if ($status['status'] != 'success') {
								// $fName = $fName;
							// } else {
								// \File::delete($fName);
								// $fName = $status['path'];
							// };
						// }
						
						$file = $request['uploadFile'.$z][$i];
						$extension = $file->getClientOriginalExtension();
						$originalName = $file->getClientOriginalName();
						$fileOriginalName = $file->getClientOriginalName();
						$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						$filename = time() . '.' . $extension;
						
						$config = config('filesystems.disks')['ftp'];
						$url = $config['url'] . $config['root'] . '/' . $filename . '/playlist.m3u8';
							
						try {
							Storage::disk('ftp')->put($filename, fopen($file, 'r+'));
		
							$this->seriesVideos->createSeriesVideos($series->id, $url, 2, $z);
						} catch (\Exception $ex) {
							logger($ex->getMessage());
						}
						
					}
				}
			}
		});
		return redirect('/admin/videos');
	}
	
	public function postAddVideo(VideoRequest $request)
	{
		DB::transaction(function () use ($request) {
			$request['thumbnailImage'] = isset($request->mythumbnail) ? $request->mythumbnail : false;
			$request['duration1'] = isset($request->duration) ? $request->duration[0] : false;
			
			$series = $this->series->createSeries($request);
			$categories = $this->videoCategories->create([
				'series_id' => $series->id,
				'category_id' => $request->category,
				'sub_category_id' => $request->subcategory,
			]);
			
			foreach ($request->tags as $val) {
				$this->videoTags->create([
					'series_id' => $series->id,
					'tag_id' => $val,
				]);
			}
			
			$request->celebrities = $request->celebrities == null ? array() : $request->celebrities;
			foreach ($request->celebrities as $val) {
				$this->videoCelebrities->create([
					'series_id' => $series->id,
					'celebrities_id' => $val,
				]);
			}
			
			for($i = 0; $i < count($request->sourceType); $i++) {
				if ((int)$request->sourceType[$i] == 1) {
					$this->seriesVideos->createSeriesVideos($series->id, $request->textSource[$i], 1, $request->duration[$i], $request->thumbnail[$i]);
				} else {
					// $file = $request->uploadFile[$i];
					// $extension = $file->getClientOriginalExtension();
					// $originalName = $file->getClientOriginalName();
					// $fileOriginalName = $file->getClientOriginalName();
					// $fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
					// $dt = Carbon::parse(Carbon::Now());
					// $timeStamp = $dt->timestamp;
					// $filename = $timeStamp . '.' . $extension; //. '__' . $fileOriginalName . '.' 
					// $upload_success = $file->move(public_path(). '/uploads', $filename);
					// $fName = asset('uploads/'.$filename);
					// $server = $this->services->getLowerTrafficServer();
					// if (count($server['data']) > 0) {
						// $fName = public_path('uploads').'/'.$filename;
						// $status = self::uploadSFTPVideo($server['data'], $fName, $filename);
						// if ($status['status'] != 'success') {
							// $fName = $fName;
						// } else {
							// \File::delete($fName);
							// $fName = $status['path'];
						// };
					// }
					// $this->seriesVideos->createSeriesVideos($series->id, $fName, 2, $request->duration[$i], $request->thumbnail[$i]);
					
					$file = $request->uploadFile[$i];
					$extension = $file->getClientOriginalExtension();
					$originalName = $file->getClientOriginalName();
					$fileOriginalName = $file->getClientOriginalName();
					$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
					$filename = time() . '.' . $extension;
					
					$config = config('filesystems.disks')['ftp'];
					$url = $config['url'] . $config['root'] . '/' . $filename . '/playlist.m3u8';
					
					try {
						Storage::disk('ftp')->put($filename, fopen($file, 'r+'));
						
						$this->seriesVideos->createSeriesVideos($series->id, $url, 2, $request->duration[$i], $request->thumbnail[$i]);
					} catch (\Exception $ex) {
						logger($ex->getMessage());
					}
				}
			}
			
		});
		
		return redirect('/admin/videos');
	}
	
	public function uploadSFTPVideo($data, $localpath, $file)
	{
		try {
			\Config::set('remote.connections.production.host', $data->ip);
			\Config::set('remote.connections.production.username', $data->user);
			\Config::set('remote.connections.production.password', $data->password);
			
			\Log::info('********************* Server Uploading *********************');
			\Log::info('remote.connections.production.host : ' . $data->ip);
			\Log::info('remote.connections.production.username : ' . $data->user);
			\Log::info('remote.connections.production.password : ' . $data->password);
			\Log::info('********************* Server Uploading *********************');
			
			(\SSH::into('production')->put(
				$localpath,
				$data->sftp_root_path.$file
			));
		
			return collect([
				'status' => true,
				'path' => $data->domain . $data->sftp_root_path . $file . '/playlist.m3u8'
			]);
		} catch (\Exception $e) {
			\Log::info('********************* Server SFTP ERROR *********************');
			\Log::info('remote.connections.production.host : ' . $data->ip);
			\Log::info('remote.connections.production.username : ' . $data->user);
			\Log::info('remote.connections.production.password : ' . $data->password);
			\Log::info('********************* Server SFTP ERROR *********************');
			\Log::info('********************* ERROR *********************');
			\Log::info($e->getMessage());
			\Log::info('********************* ERROR *********************');
			
			$this->servers->where('id', '=', $data->id)->update([
				'sftp_status' => 2
			]);
			$data = $this->services->getLowerTrafficServer();
			if(count($data['data']) > 0) {
				self::uploadSFTPVideo($data);
			} else {
				return collect([
					'status' => false
				]);
			}
		}
	}
	
	public function getVideo($videoId)
	{
		$series = $this->series->getSeries($videoId);
		$subCatId = $series->seriesCategory->category_id;
//		dd($series->seriesCategory->id);
		return view('admin.videos.edit',[
			'series' => $series,
			'categories' => $this->categories->getCategories(false, true),
			'subCategories' => $this->categories->getSubCategories($subCatId, true),
			'tags' => $this->tags->get(),
			'celebrities' =>$this->celebrities->getAllCelebrities(),
			'config' => $this->config->first()
		]);
	}

	public function updateVideoMultiple(VideoRequest $request)
	{
		$oldData = json_decode($request->oldData);
		
		$arr1 = new Collection();
		$arr2 = new Collection();
		$arr3 = new Collection();
		$d = (json_decode($request->dat));
		foreach ((array)$d as $key => $val) {
			if ($val->source_no == 1) {
				$arr1->push($val);
			}
			if ($val->source_no == 2) {
				$arr2->push($val);
			}
			if ($val->source_no == 3) {
				$arr3->push($val);
			}
		}
		
		
		DB::transaction(function () use ($request, $oldData, $arr1, $arr2, $arr3) {
			
			$request['thumbnailImage'] = isset($request->mythumbnail) ? $request->mythumbnail : false;
			
			$series = $this->series->updateSeries($request);
			$categories = $this->videoCategories->where('series_id', '=', $request->series_id)->update([
				'category_id' => $request->category,
				'sub_category_id' => $request->subcategory
			]);
			$this->videoTags->where('series_id', '=', $request->series_id)->delete();
			
			foreach ($request->tags as $val) {
				$this->videoTags->create([
					'series_id' => $request->series_id,
					'tag_id' => $val,
				]);
			}
			
			$request->celebrities = $request->celebrities == null ? array() : $request->celebrities;
			
			$this->videoCelebrities->where('series_id', '=', $request->series_id)->delete();
			foreach ($request->celebrities as $val) {
				$this->videoCelebrities->create([
					'series_id' => $request->series_id,
					'celebrities_id' => $val,
				]);
			}
			
			for($i = 0; $i < count($request->sourceType1); $i++) {
				if ((int)$request->sourceType1[$i] == 1) {
					if ($i < count($arr1)) {
//						dd($request->textSource1);
						$this->seriesVideos->updateSeriesVideos($request->series_id, $request->textSource1[$i], 1, $arr1[$i]->id);
					} else {
						$this->seriesVideos->createSeriesVideos($request->series_id, $request->textSource1[$i], 1, 1, '', 1);
					}
				} else {
					
					if (isset($request->uploadFile1[$i])) {
						// $file = $request->uploadFile1[$i];
						// $extension = $file->getClientOriginalExtension();
						// $originalName = $file->getClientOriginalName();
						// $fileOriginalName = $file->getClientOriginalName();
						// $fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						// // $dt = Carbon::parse(Carbon::Now());
						// // $timeStamp = $dt->timestamp;
						// $filename = time() . '.' . $extension;
						// $upload_success = $file->move(public_path() . '/uploads', $filename);
						// $fName = asset('uploads/'.$filename);
						
						// $server = $this->services->getLowerTrafficServer();
						// if (count($server['data']) > 0) {
							// $fName = public_path('uploads').'/'.$filename;
							// $status = self::uploadSFTPVideo($server['data'], $fName, $filename);
							// if ($status['status'] != 'success') {
								// $fName = $fName;
							// } else {
								// \File::delete($fName);
								// $fName = $status['path'];
							// };
						// }
						
						
						// if ($i < count($arr1)) {
							// $this->seriesVideos->updateSeriesVideos($request->series_id, $fName, 2, $arr1[$i]->id);
						// } else {
							// $this->seriesVideos->createSeriesVideos($request->series_id, $fName, 2, 1, '', 1);
						// }
						
						$file = $request->uploadFile1[$i];
						
						$extension = $file->getClientOriginalExtension();
						$originalName = $file->getClientOriginalName();
						$fileOriginalName = $file->getClientOriginalName();
						$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						$filename = time() . '.' . $extension;
						
						$config = config('filesystems.disks')['ftp'];
						$url = $config['url'] . $config['root'] . '/' . $filename . '/playlist.m3u8';
							
						try {
							Storage::disk('ftp')->put($filename, fopen($file, 'r+'));
		
							if ($i < count($arr1)) {
								$this->seriesVideos->updateSeriesVideos($request->series_id, $url, 2, $arr1[$i]->id);
							} else {
								$this->seriesVideos->createSeriesVideos($request->series_id, $url, 2, 1, '', 1);
							}
						
						} catch (\Exception $ex) {
							logger($ex->getMessage());
						}
					}
				}
			}
			
			
			for($i = 0; $i < count($request->sourceType2); $i++) {
				if ((int)$request->sourceType2[$i] == 1) {
//					dump(count($request->sourceType2));
//					dd(count($arr2));
					if ($i < count($arr2)) {
						$this->seriesVideos->updateSeriesVideos($request->series_id, $request->textSource2[$i], 1, $arr2[$i]->id);
					} else {
						$this->seriesVideos->createSeriesVideos($request->series_id, $request->textSource2[$i], 1, 2, '', 2);
					}
				} else {
					if (isset($request->uploadFile2[$i])) {
						// $file = $request->uploadFile2[$i];
						// $extension = $file->getClientOriginalExtension();
						// $originalName = $file->getClientOriginalName();
						// $fileOriginalName = $file->getClientOriginalName();
						// $fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						// // $dt = Carbon::parse(Carbon::Now());
						// // $timeStamp = $dt->timestamp;
						// $filename = time() . '.' . $extension;
						// $upload_success = $file->move(public_path() . '/uploads', $filename);
						// $fName = asset('uploads/'.$filename);
						
						// $server = $this->services->getLowerTrafficServer();
						// if (count($server['data']) > 0) {
							// $fName = public_path('uploads').'/'.$filename;
							// $status = self::uploadSFTPVideo($server['data'], $fName, $filename);
							// if ($status['status'] != 'success') {
								// $fName = $fName;
							// } else {
								// \File::delete($fName);
								// $fName = $status['path'];
							// };
						// }
						
						
						// if ($i < count($arr2)) {
							// $this->seriesVideos->updateSeriesVideos($request->series_id, $fName, 2, $arr2[$i]->id);
						// } else {
							// $this->seriesVideos->createSeriesVideos($request->series_id, $fName, 2, 2, '', 2);
						// }
						
						$file = $request->uploadFile2[$i];
						$extension = $file->getClientOriginalExtension();
						$originalName = $file->getClientOriginalName();
						$fileOriginalName = $file->getClientOriginalName();
						$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						$filename = time() . '.' . $extension;
						
						$config = config('filesystems.disks')['ftp'];
						$url = $config['url'] . $config['root'] . '/' . $filename . '/playlist.m3u8';
							
						try {
							Storage::disk('ftp')->put($filename, fopen($file, 'r+'));
		
							if ($i < count($arr2)) {
								$this->seriesVideos->updateSeriesVideos($request->series_id, $url, 2, $arr2[$i]->id);
							} else {
								$this->seriesVideos->createSeriesVideos($request->series_id, $url, 2, 2, '', 2);
							}
						
						} catch (\Exception $ex) {
							logger($ex->getMessage());
						}
					}
				}
			}
			
			
			for($i = 0; $i < count($request->sourceType3); $i++) {
				if ((int)$request->sourceType3[$i] == 1) {
					if ($i < count($arr3)) {
						$this->seriesVideos->updateSeriesVideos($request->series_id, $request->textSource3[$i], 1, $arr3[$i]->id);
					} else {
						$this->seriesVideos->createSeriesVideos($request->series_id, $request->textSource3[$i], 1,3, '', 3);
					}
				} else {
					if (isset($request->uploadFile3[$i])) {
						// $file = $request->uploadFile3[$i];
						// $extension = $file->getClientOriginalExtension();
						// $originalName = $file->getClientOriginalName();
						// $fileOriginalName = $file->getClientOriginalName();
						// $fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						// // $dt = Carbon::parse(Carbon::Now());
						// // $timeStamp = $dt->timestamp;
						// $filename = time() . '.' . $extension;
						// $upload_success = $file->move(public_path() . '/uploads', $filename);
						// $fName = asset('uploads/'.$filename);
						
						// $server = $this->services->getLowerTrafficServer();
						// if (count($server['data']) > 0) {
							// $fName = public_path('uploads').'/'.$filename;
							// $status = self::uploadSFTPVideo($server['data'], $fName, $filename);
							// if ($status['status'] != 'success') {
								// $fName = $fName;
							// } else {
								// \File::delete($fName);
								// $fName = $status['path'];
							// };
						// }
						
						
						// if ($i < count($arr3)) {
							// $this->seriesVideos->updateSeriesVideos($request->series_id, $fName, 2, $arr3[$i]->id);
						// } else {
							// $this->seriesVideos->createSeriesVideos($request->series_id, $fName, 2, 3, '', 3);
						// }
						
						$file = $request->uploadFile3[$i];
						$extension = $file->getClientOriginalExtension();
						$originalName = $file->getClientOriginalName();
						$fileOriginalName = $file->getClientOriginalName();
						$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						$filename = time() . '.' . $extension;
						
						$config = config('filesystems.disks')['ftp'];
						$url = $config['url'] . $config['root'] . '/' . $filename . '/playlist.m3u8';
							
						try {
							Storage::disk('ftp')->put($filename, fopen($file, 'r+'));
		
							if ($i < count($arr3)) {
								$this->seriesVideos->updateSeriesVideos($request->series_id, $url, 2, $arr3[$i]->id);
							} else {
								$this->seriesVideos->createSeriesVideos($request->series_id, $url, 2, 3, '', 3);
							}
						
						} catch (\Exception $ex) {
							logger($ex->getMessage());
						}
					}
				}
			}
			
		});
		return redirect('/admin/videos');
	}

	public function updateVideo(VideoRequest $request)
	{
		$oldData = json_decode($request->oldData);
		DB::transaction(function () use ($request, $oldData) {
			
//			$thumb = false;
//			if (isset($request->mythumbnail)) {
//				$file = $request->mythumbnail;
//				$extension = $file->getClientOriginalExtension();
//				$originalName = $file->getClientOriginalName();
//				$fileOriginalName = $file->getClientOriginalName();
//				$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
//				$dt = Carbon::parse(Carbon::Now());
//				$timeStamp = $dt->timestamp;
//				$filename = $timeStamp . '__' . $fileOriginalName . '.' . $extension;
//				$upload_success = $file->move(public_path() . '/uploads', $filename);
//				$thumb = asset('uploads/' . $filename);
//			}
			$request['thumbnailImage'] = isset($request->mythumbnail) ? $request->mythumbnail : false;
			$request['duration1'] = isset($request->duration) ? $request->duration[0] : false;
			
			$series = $this->series->updateSeries($request);
			$categories = $this->videoCategories->where('series_id', '=', $request->series_id)->update([
				'category_id' => $request->category,
				'sub_category_id' => $request->subcategory
			]);
			$this->videoTags->where('series_id', '=', $request->series_id)->delete();
			
			foreach ($request->tags as $val) {
				$this->videoTags->create([
					'series_id' => $request->series_id,
					'tag_id' => $val,
				]);
			}
			
			$request->celebrities = $request->celebrities == null ? array() : $request->celebrities;
			
			$this->videoCelebrities->where('series_id', '=', $request->series_id)->delete();
			foreach ($request->celebrities as $val) {
				$this->videoCelebrities->create([
					'series_id' => $request->series_id,
					'celebrities_id' => $val,
				]);
			}
			
			for($i = 0; $i < count($request->sourceType); $i++) {
				if ((int)$request->sourceType[$i] == 1) {
					if ($i < count($oldData)) {
						$this->seriesVideos->updateSeriesVideos($request->series_id, $request->textSource[$i], 1, $oldData[$i]->id, $request->duration[$i], $request->thumbnail[$i]);
					} else {
						$this->seriesVideos->createSeriesVideos($request->series_id, $request->textSource[$i], 1, $request->duration[$i], $request->thumbnail[$i]);
					}
				} else {
					if (isset($request->uploadFile[$i])) {
						// $file = $request->uploadFile[$i];
						// $extension = $file->getClientOriginalExtension();
						// $originalName = $file->getClientOriginalName();
						// $fileOriginalName = $file->getClientOriginalName();
						// $fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						// // $dt = Carbon::parse(Carbon::Now());
						// // $timeStamp = $dt->timestamp;
						// $filename = time() . '.' . $extension;
						// $upload_success = $file->move(public_path() . '/uploads', $filename);
						// $fName = asset('uploads/'.$filename);
						
						// $server = $this->services->getLowerTrafficServer();
						// if (count($server['data']) > 0) {
							// $fName = public_path('uploads').'/'.$filename;
							// $status = self::uploadSFTPVideo($server['data'], $fName, $filename);
							// if ($status['status'] != 'success') {
								// $fName = $fName;
							// } else {
								// \File::delete($fName);
								// $fName = $status['path'];
							// };
						// }
						
						
						// if ($i < count($oldData)) {
							// $this->seriesVideos->updateSeriesVideos($request->series_id, $fName, 2, $oldData[$i]->id, $request->duration[$i], $request->thumbnail[$i]);
						// } else {
							// $this->seriesVideos->createSeriesVideos($request->series_id, $fName, 2, $request->duration[$i], $request->thumbnail[$i]);
						// }
						
						$file = $request->uploadFile[$i];
						$extension = $file->getClientOriginalExtension();
						$originalName = $file->getClientOriginalName();
						$fileOriginalName = $file->getClientOriginalName();
						$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
						$filename = time() . '.' . $extension;
						
						$config = config('filesystems.disks')['ftp'];
						$url = $config['url'] . $config['root'] . '/' . $filename . '/playlist.m3u8';
							
						try {
							Storage::disk('ftp')->put($filename, fopen($file, 'r+'));
		
							if ($i < count($oldData)) {
								$this->seriesVideos->updateSeriesVideos($request->series_id, $url, 2, $oldData[$i]->id, $request->duration[$i], $request->thumbnail[$i]);
							} else {
								$this->seriesVideos->createSeriesVideos($request->series_id, $url, 2, $request->duration[$i], $request->thumbnail[$i]);
							}
						
						} catch (\Exception $ex) {
							logger($ex->getMessage());
						}
					}
				}
			}
			
		});
		return redirect('/admin/videos');
	}
	public function removeSeriesVideo($videoId)
	{
		$seriesVideo = $this->seriesVideos->where('id', $videoId)->first();
		
		$tmp = explode('/', $seriesVideo->path);
		
		foreach ($tmp as $el)
		{
			if (stripos($el, '.mp4') !== false)
			{
				Storage::disk('ftp')->delete($el);
			}
		}
		
		$seriesVideo->delete();
		
		return collect([
			'status' => 'success'
		]);
	}
	
	public function deleteVideo($videoId)
	{
		DB::transaction(function () use ($videoId) {
			$seriesVideo_paths = $this->seriesVideos->where('series_id', $videoId)->pluck('path');
			
			foreach ($seriesVideo_paths as $path) {
				$tmp = explode('/', $path);

				foreach ($tmp as $el)
				{
					if (stripos($el, '.mp4') != false)
					{
						Storage::disk('ftp')->delete($el);
					}
				}
			}
			
			$this->series->where('id', '=', $videoId)->delete();
			
			$this->seriesVideos->where('series_id', '=', $videoId)->delete();
			
			$this->videoCategories->where('series_id', '=', $videoId)->delete();
			$this->videoTags->where('series_id', '=', $videoId)->delete();
			$this->celebrityAlbum->where('series_id', '=', $videoId)->delete();
			$this->videoGroupsSeries->where('series_id', '=', $videoId)->delete();
		});
		return redirect('/admin/videos');
	}
	
	public function adds()
	{
		$add = $this->adds->first();
		return view('admin.adds.index',[
			'adds' => isset($add) && count($add) > 0 ? $add : array()
		]);
	}
	
	public function PostAdds(Request $request)
	{
		$this->adds->saveAdd($request);
		return redirect()->back();
	}
}
