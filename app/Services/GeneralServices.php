<?php

namespace App\Services;

use App\Models\Adds;
use App\Models\Series;
use App\Models\Servers;
use App\Models\WebsiteModules;
use App\StepsProgress;
use App\User, Cache;
use App\Models\websiteConfiguration;
use Carbon\Carbon;
use App\Helpers\Common;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: ahsan
 * Date: 27/09/16
 * Time: 12:44 PM
 */
class GeneralServices
{
	public function uploadFile($request, $path, $fileName)
	{
		if (!$path)
			return false;
		
		try {
			$dt = Carbon::parse(Carbon::Now());
			$timeStamp = $dt->timestamp;
			$destinationPath = public_path() . '/' .$path;
			$file = Input::file($fileName);
			$extension = Input::file($fileName)->getClientOriginalExtension();
			$originalName = Input::file($fileName)->getClientOriginalName();
			$fileOriginalName = Input::file($fileName)->getClientOriginalName();
			$fileOriginalName = str_replace('.' . $extension, "", $fileOriginalName);
			$fileName = $timeStamp . '__' . $fileOriginalName . '.' . $extension;
			$file->move($destinationPath, $fileName);
			return collect([
				'status' => 'success',
				'icon' => $fileName,
				'fileName' => $originalName
			]);
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function getAdds()
	{
		$this->adds = new Adds();
		return collect([
			'data' => $this->adds->first()
		]);
	}
	
	public function getAllSeries()
	{
		$this->series = new Series();
		$series = $this->series->getAllSeries(true);
		
		$arr = array();
		
		foreach ($series as $key=> $val) {
			array_push($arr, array(
				'value' => $val->name,
				'id' => $val->id
			));
		}
		
		return collect([
			'data' => json_encode($arr)
		]);
		
	}
	
	public function pluckLinkFromVimeo($path)
	{
		try {
			$path = explode('/', $path);
			$index = count($path);
			return ($path[$index - 1]);
		} catch (\Exception $e) {
			return 0;
		}
	}
	
	public function pluckLinkFromVidMe($path)
	{
		try {
			$path = explode('/', $path);
			$index = count($path);
			return ($path[$index - 1]);
		} catch (\Exception $e) {
			return 0;
		}
	}
	
	public function pluckLinkFromFlickr($path)
	{
		try {
			$path = explode('/in/', $path);
			$path = explode('/', $path[0]);
			return ($path[count($path)-1]);
		} catch (\Exception $e) {
			return 0;
		}
	}
	
	public function generateVidMeLink($path){
		try {
			$id = (self::pluckLinkFromVidMe($path));
			
			$key = 'vidme-' . $id;
				
			if (Cache::has($key))
			{
				$sources = Cache::get($key);
				
				return collect([
					'status' => 'success',
					'url' => $sources,
					'fallback_url' => str_replace('vid.me/', 'vid.me/e/', $path)
				]);
			}
				
			$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.vid.me/']);
			$response = $client->request("GET", "videoByUrl?url=" . urlencode("https://vid.me/{$id}"), [
				'verify' => false,
				'headers' => ['Authorization' => "Basic MNIwXpRgHWFkJVwjR93RUcFh66tbaPFI"]
			]);
			
			$sources = array();
			
			$response = (string)$response->getBody();
			
			$json = json_decode($response, 1);
			
			if (isset($json['video']['formats']))
			{				
				foreach($json['video']['formats'] as $video)
				{
					if (strpos($response, '.mp4') === false)
					{
						if ($video['type'] == 'dash')
						{
							$sources = [];
							
							$sources[] = [
								'type' => 'dash',
								'label' =>  $video['type'],
								'file' =>  $video['uri'],
							];
							
							break;
						}
					}
			
					if (preg_match('#dash|hls|clip#is', $video['type']))
					{
						continue;    
					}
					
					$source = [
							'type' => 'video/mp4',
							'label' =>  $video['type'],
							'file' =>  $video['uri'],
						];
						
					if ($video['type'] == '720p')
					{
						$source['default'] = true;
					}
					
					$sources[] = $source;
				}
			}
	
			Cache::put($key, $sources, 120);
			
			//$url = ($json->video->complete_url);
			return collect([
				'status' => 'success',
				'url' => $sources,
				'fallback_url' => str_replace('vid.me/', 'vid.me/e/', $path)
			]);
		} catch (\Exception $e) {
			return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
		}
	}
	
	public function generateFlickrLink($link)
	{
		try {
			$id = self::pluckLinkFromFlickr($link);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.flickr.com/services/rest/?api_key=a4082ee42098774141f253f50b9584a1&photo_id=" . $id . "&method=flickr.photos.getsizes&format=json&dataType=application%2Fjson",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"postman-token: a72ddc8a-1ff3-9b52-7f12-bb6ddf0a0b5a"
				),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
				return collect([
					'status' => 'failure',
					'url' => 'http://'
				]);
			} else {
				$response = substr(str_replace('jsonFlickrApi(', '', $response), 0, -1);
				$response = json_decode($response);
				return collect([
					'status' => 'success',
					'url' => $response->sizes->size[count($response->sizes->size) - 1]->source
				]);
			}
		} catch (\Exception $e) {
			return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
		}
	}
	
	public function generateVimeoLink($path)
	{
		try {
			$id = self::pluckLinkFromVimeo($path);
			if ($id > 0) {
				
				$key = 'vimeo-' . $id;
				
				if (Cache::has($key))
				{
					$url = Cache::get($key);
					
					return collect([
						'status' => 'success',
						'url' => $url
					]);
				}
		
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://player.vimeo.com/video/" . $id . "/config",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"postman-token: cf360244-bb9e-bcee-da4e-21c9e6b516e4"
					),
				));
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				
				if ($err) {
					return collect([
						'status' => 'failure',
						'url' => 'http://'
					]);
				} else {
					$t = json_decode($response, 1);
					
					$url = '';
					if (isset($t['request']['files']))
					{
						if (isset($t['request']['files']['hls']['default_cdn']))
						{
							$default_hls = $t['request']['files']['hls']['default_cdn'];
							
							$url = $t['request']['files']['hls']['cdns'][$default_hls]['url'];
							
							Cache::put($key, $url, 60);
						}
					}

					return collect([
						'status' => 'success',
						'url' => $url
					]);
				}
			} else {
				return collect([
					'status' => 'failure',
					'url' => 'http://'
				]);
			}
		} catch (\Exception $e) {
			return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
		}
	}
	
	public function curlYandex($url) {
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "Connection: keep-alive";
		$head[] = "Keep-Alive: 300";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: en-us,en;q=0.5";
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}
	
	public function generateYandexLink($path){
		
		if (Cache::has($path))
		{			
			return collect([
				'status' => 'success',
				'url' => Cache::get($path)
			]);
		}
		
		try {
			$arr = explode('/', $path);
			$in = count($arr) - 1;
			$link = json_decode(self::curlYandex('https://cloud-api.yandex.net/v1/disk/public/resources/download?public_key=' . urlencode('https://yadi.sk/i/' . $arr[$in])));
			
			if (isset($link->href))
			{
				Cache::put($path, $link->href, 120);
				
				return collect([
					'status' => 'success',
					'url' => $link->href
				]);
			}
		} catch (\Exception $e){
			return collect([
				'status' => 'failure',
				'url' => ''
			]);
		}
	}
	
	public function generateBoxLink($path)
	{
		// if (Cache::has($path))
		// {
			// return collect([
				// 'status' => 'success',
				// 'url' => Cache::get($path)
			// ]);
		// }
		
		$box = Common::cURL($path);
		
		if (preg_match('#"itemID":(.*?),"#is', $box, $match))
		{
			$file_id = $match[1];
			$_link = explode('/', $path);
			$shared_name = end($_link);
			
			$url = Common::getRedirect('https://app.box.com/index.php?rm=box_download_shared_file&shared_name=' . $shared_name . '&file_id=f_' . $file_id);

			if (!empty($url))
			{
				Cache::put($path, $url, 1440);
				
				return collect([
					'status' => 'success',
					'url' => $url
				]);
			}
		}
		

		return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
	}
	
	public function generateBestreamLink($path)
	{
		if (Cache::has($path))
		{
			return collect([
				'status' => 'success',
				'url' => Cache::get($path)
			]);
		}
		
		if (preg_match('#bestream.tv/(.*?)/#is', $path, $match))
		{
			$id = $match[1];
		
			$content = Common::cURL("http://putlocker.center/plugins/mediaplayer/site/_embed-bestream.php?u=$id&r=bestream.tv");
			
			if (preg_match('#file: "(.*?)",#is', $content, $file))
			{
				$url = $file[1];
				
				Cache::put($path, $url, 1440);
				
				return collect([
					'status' => 'success',
					'url' => $url
				]);
			}
		}

		return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
	}
	
	public function generateFembedLink($path)
	{
		if (!preg_match('#/v/(.*?)$#is', $path, $match))
		{
			goto end_fembed;
		}
		
		$v = trim($match[1]);

		$key = 'fembed-' . $v;
		
		if (Cache::has($key))
		{
			return collect([
				'status' => 'success',
				'url' => Cache::get($key),
				'fallback_url' => $path
			]);
		}
		
		$json = Common::cURLFembed($v);
	
		$data = json_decode($json, 1);

		if (count($data['data']) > 0)
		{
			$sources = [];
			
			foreach ($data['data'] as $file)
			{
				$file['file'] = Common::getRedirectURL($file['file']);
				$sources[] = $file;
			}
			
			if (!empty($sources))
			{
				Cache::put($key, $sources, 60);
				
				return collect([
					'status' => 'success',
					'url' => $sources,
					'fallback_url' => $path
				]);
			}
		}

		end_fembed:
		return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
	}
	
	public function generateDailymotionLink($path)
	{
		
		if (Cache::has($path))
		{
			// return collect([
				// 'status' => 'success',
				// 'url' => route('seriesVideosDailymotion', ['path' => encrypt($path)])
			// ]);
		}
		
		
				
		$response = Common::cURL($path);

		$url = '';
		
		if (empty($response)) {
			return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
		} else {
			if (preg_match('#var config = \{(.*?)\};#is', $response, $match) || preg_match('#var __PLAYER_CONFIG__ = \{(.*?)\};#is', $response, $match))
			{
				$config = json_decode('{' . $match[1] . '}', 1);
		
				if (isset($config['metadata']['qualities']['auto'][0]['url']))
				{
					$file = $config['metadata']['qualities']['auto'][0]['url'];
					
					$m3u8 = Common::cURL($file);
	
					if (!empty($m3u8))
					{
						if (preg_match('#auth=(.*?)-#is', $file, $epxtime))
						{
							$ttl = round(($epxtime[1] - time()) / 60);
						} else {
							$ttl = 120;
						}
						
						$url = route('seriesVideosDailymotion', ['path' => encrypt($path)]);

						Cache::put($path, str_replace('http:', 'https:', $m3u8), $ttl);
					}
				}
			}
		}

		return collect([
				'status' => 'success',
				'url' => $url
			]);
	}
	
	public function generateYoutubeLink($path)
	{
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $path, $match))
		{
			$id = $match[1];
		} else {
			return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
		}
		
		$key = 'youtube-' . $id;
		
		if (Cache::has($key))
		{
			$sources = Cache::get($key);
			
			return collect([
				'status' => 'success',
				'url' => $sources,
				'fallback_url' => $path
			]);
		}
		
		$sources = [];
	
		$content = Common::cURL('https://youtube.com/get_video_info?fmt=18&asv=2&hd=1&video_id=' . $id);

		if (!empty($content))
		{
			parse_str($content, $youtube);

			if (isset($youtube['status']) && $youtube['status'] == 'ok')
			{
				$itags = array(
							'18' => 360, 
							'22' => 720, 
						);
						
				$keys = array_keys($itags);
				
				$streams = explode(',', $youtube['url_encoded_fmt_stream_map']);
				
				foreach ($streams as $stream)
				{
					parse_str($stream, $array);

					if (in_array($array['itag'], $keys))
					{
						//parse_str($array['url'], $query);

						//$ttl = $query['expire'] - time();

						$label = $itags[$array['itag']];
						
						$source = array('label' => $label . 'p', 'type' => 'video/mp4', 'file' => $array['url']);
						
						if ($label == 720)
						{
							$source['default'] = true;
						}
						
						$sources[$label] = $source;
					}
				}
			}
		}

		$sources = array_values($sources);

		if (!empty($sources))
		{
			Cache::put($key, $sources, 120);
			
			return collect([
				'status' => 'success',
				'url' => $sources,
				'fallback_url' => $path
			]);
		}

		return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
	}
	
	public function generateFacebookLink($path)
	{
		if (preg_match("~/videos/(?:t\.\d+/)?(\d+)~i", $path, $match))
		{
			$id = $match[1];
		} else {
			return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
		}
		
		$key = 'facebook-' . $id;
		
		if (Cache::has($key))
		{
			$sources = Cache::get($key);
			
			return collect([
				'status' => 'success',
				'url' => $sources
			]);
		}
		
		$sources = [];
	
		$content = Common::cURL("https://www.facebook.com/video/embed?video_id=$id");

		if (!empty($content) && preg_match('#videoData"\:\[(.*?)\}\]#is', $content, $match)) {
			$json = json_decode(str_replace('videoData":', '', $match[0]));
			
			if (!empty($json) && (isset($json[0]->sd_src_no_ratelimit) || isset($json[0]->hd_src_no_ratelimit) || isset($json[0]->sd_src) || isset($json[0]->hd_src)))
			{
				if (isset($json[0]->sd_src_no_ratelimit))
				{
					$sd_url = $json[0]->sd_src_no_ratelimit;
				} elseif (isset($json[0]->sd_src))
				{
					$sd_url = $json[0]->sd_src;
				}
				
				if (isset($sd_url))
				{
					$sources[] = [
						'type' => 'video/mp4',
						'label' => 'SD',
						'file' => $sd_url,
					];				
				}
				
				if (isset($json[0]->hd_src_no_ratelimit))
				{
					$hd_url = $json[0]->hd_src_no_ratelimit;
				} elseif (isset($json[0]->hd_src))
				{
					$hd_url = $json[0]->hd_src;
				}
				
				if (isset($hd_url))
				{
					$sources[] = [
						'type' => 'video/mp4',
						'label' => 'HD',
						'file' => $hd_url,
					];
				}
			}
		}

		if (!empty($sources))
		{
			Cache::put($key, $sources, 120);
			
			return collect([
				'status' => 'success',
				'url' => $sources
			]);
		}

		return collect([
				'status' => 'failure',
				'url' => 'http://'
			]);
	}
	
	public function getLowerTrafficServer()
	{
		$this->servers =  new Servers();
		$data = $this
			->servers
			->where('active', 1)
			->where('sftp_status', 1)
			->orderBy('videos_uploaded', 'asc')
			->first();
		return collect([
			'status' => 'success',
			'data' => $data
		]);
	}

    public function cleanVideoName($name)
    {
        return (str_replace('-', ' ', $name));
    }

	
	public function getAppName()
	{
		$this->websiteConfiguration = new websiteConfiguration();
		$data = $this->websiteConfiguration->getConfig();
		return collect([
			'status' => 'success',
			'data' =>$data
		]);
	}

	public function getModuleConfig()
	{
		$this->websiteModules = new WebsiteModules();
		$data = $this->websiteModules->getModules();
		return collect([
			'status' => 'success',
			'data' => $data
		]);
	}

	/**
	 * Push Notifications
	 * */
	
	/**
	 * Android Application
	 * */
	
	public function androidPush($deviceToken, $message)
	{
		$reg = $deviceToken;
		$apiKey = "AAAAuDBsPgA:APA91bEbULP0UQp77Rm42o46tISF6U3TTRlGYek92T5KM5gENtbHlZ5kBD4slgevSntiOm8usQz_zD165WDnlKpzOHibNzMmtXN_rGYK2KUChFffnw7XHurSSqc5d4tmyiW6FYlljNtn";
		$registatoin_ids = $deviceToken;
		
		// Set POST variables
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			'registration_ids' => $registatoin_ids,
			'data' => array (
				"id" => $message->id,
				"thumbnail"=> $message->thumbnail,
				'title' => $message->name,
				'description'=> $message->description
			),
		);
		
		$headers = array(
			'Authorization: key=' .$apiKey,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		// Execute post
		$result = curl_exec($ch);
		
//		echo $result;
		if ($result === FALSE) {
			 die('Curl failed: ' . curl_error($ch));
		}
		
		// Close connection
		curl_close($ch);
		return true;

	}








public function iosPush($deviceToken, $message)
	{
		$reg = $deviceToken;
		$apiKey = "AAAAuDBsPgA:APA91bEbULP0UQp77Rm42o46tISF6U3TTRlGYek92T5KM5gENtbHlZ5kBD4slgevSntiOm8usQz_zD165WDnlKpzOHibNzMmtXN_rGYK2KUChFffnw7XHurSSqc5d4tmyiW6FYlljNtn";
		$registatoin_ids = $deviceToken;
		
		// Set POST variables
		$url = 'https://fcm.googleapis.com/fcm/send';
		 

	$fcmMsg = array(
			'body' => $message->description,
			//'title' => $message->name,
			'title' => "Nohay Collection",
			'sound' => "default",
			"id" => $message->id,
			"thumbnail"=> $message->thumbnail,
	);


	$fields = array(
		'registration_ids' => $registatoin_ids,
	     'priority' => 'high',
		'notification' => $fcmMsg
	);
 
		$headers = array(
			'Authorization: key=' .$apiKey,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		// Execute post
		$result = curl_exec($ch);
		
//		echo $result;
		if ($result === FALSE) {
			 die('Curl failed: ' . curl_error($ch));
		}
		
		// Close connection
		curl_close($ch);
		return true;

	}
	
	
	public function  generateRandomString($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		$dt = Carbon::parse(Carbon::Now());
		$timeStamp = $dt->timestamp;
		return $timeStamp.'_'.$randomString;
	}

	
}