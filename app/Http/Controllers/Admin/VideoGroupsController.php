<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VideoGroupRequest;
use App\Models\Cities;
use App\Models\CombinationImages;
use App\Models\Places;
use App\Models\Series;
use App\Models\VideoGroups;
use App\Models\VideoGroupsCategories;
use App\Models\VideoGroupsCategoriesSeries;
use App\Models\VideoGroupsSeries;
use App\Services\GeneralServices;
use Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

require_once(public_path().('/assets/client/p21/persian_log2vis.php'));

class VideoGroupsController extends Controller
{

	protected $cities;
	protected $videos;
	protected $videoGroups;
	protected $videoGroupsSeries;
	protected $places;
	protected $videoGroupCategories;
	protected $videoGroupCategoriesSeries;
	protected $generalService;
	protected $combinationImage;
	
	function __construct()
	{
		$this->cities = new Cities();
		$this->videos = new Series();
		$this->videoGroups = new VideoGroups();
		$this->videoGroupsSeries = new VideoGroupsSeries();
		$this->places = new Places();
		$this->videoGroupCategories = new VideoGroupsCategories();
		$this->videoGroupCategoriesSeries = new VideoGroupsCategoriesSeries();
		$this->generalService = new GeneralServices();
		$this->combinationImage = new CombinationImages();
	}
	
	public function index(Request $request)
	{
		return view('admin.videoGroups.index',[
			'groups' => $this->videoGroups->getAllVideoGroups()
		]);
	}
	
	public function create(Request $request)
	{
		return view('admin.videoGroups.add',[
			'videos' => $this->videos->getAllSeries(),
			'cities' => $this->cities->getAllCities(),
            'videoGroupCategories' => $this->videoGroupCategories->getGroupCategories()
        ]);
	}
	
	public function store(Request $request)
	{
		try {
			$imageData = $this->combinationImage->getImageDetailByCitAndPlace($request->city_id, $request->place_id);
//			if(isset($imageData)) {
				\DB::transaction(function () use ($request, $imageData) {
					$image = self::createVGImage($request, $imageData);
					$request['thumbnail'] = \URL::to('/') . '/uploads/' . $image['name'];
					$group = $this->videoGroups->createVideoGroups($request);
					foreach ($request->videos as $key => $val) {
						$this->videoGroupsSeries->createAlbumSeries($val, $group->id);
					}
					$this->videoGroupCategoriesSeries->createVideoGroupCategorySeries($group->id, $request->category_id);
				});
				return redirect('/admin/video-groups');
//			} else {
//				return redirect()->back()->with('error', 'Please upload Place/City Image from Combinational Images Module');
//			}
		} catch (\Exception $e){
			dump($e);
			dd('Exception while creating Video Group');
		}
	}
	
	public function edit(Request $request ,$id)
	{
		$data = $this->videoGroups->getVideoGroupById($id);
		return view('admin.videoGroups.edit',[
			'data' => $data,
			'videos' => $this->videos->getAllSeries(),
			'cities' => $this->cities->getAllCities(),
			'selectedPlaces' => $this->places->getPlaces($data->city_id),
      'videoGroupCategories' => $this->videoGroupCategories->getGroupCategories()
		]);
	}
	
	public function update(Request $request, $id)
	{
		$imageData = ($this->combinationImage->getImageDetailByCitAndPlace($request->city_id,$request->place_id));
//		if(isset($imageData) && count($imageData) > 0) {
			\DB::transaction(function () use ($request, $id, $imageData) {
				$image = self::createVGImage($request, $imageData);
				$request['thumbnail'] = \URL::to('/') . '/uploads/' . $image['name'];
				self::removeOldThumb($request->oldThumb);
				$group = $this->videoGroups->updateVideoGroups($request, $id);
				$this->videoGroupsSeries->deleteAlbumSeries($id);
				foreach ($request->videos as $key => $val) {
					$this->videoGroupsSeries->createAlbumSeries($val, $id);
				}
				$this->videoGroupCategoriesSeries->updateVideoGroupCategorySeries($id, $request->category_id);
			});
//		} else {
//			return redirect()->back()->with('error', 'Please upload Place/City Image from Combinational Images Module');
//		}
		return redirect('/admin/video-groups');
	}

	public function delete($id)
	{
		($this->videoGroups->deleteVideoGroups($id));
		return redirect()->back();
	}
	
	public function removeOldThumb($path)
	{
		try {
			$path = explode('/', $path);
			$len = count($path);
			$image = $path[$len - 1];
			unlink(public_path() . '/uploads/' . $image);
		} catch (\Exception $e) {
		
		}
	}
	
	public function getStampAbsolutePath($image)
	{
		$imageArray = explode('/',$image);
		$uploadPath = strstr($image, 'assets');
		$absolutePath = public_path().'/'.$uploadPath;
		$type = strpos($absolutePath, 'png') > 0 ? 'png': 'jpeg';
		return collect([
			'absolute_path' => str_replace('%20',' ',$absolutePath),
			'image_type' => $type,
			'is_png' => $type == 'png' ? true : false,
			'base_name' => basename($absolutePath)
		]);
	}
	
	public function createVGImage($data, $image)
	{
		try {
			$dateEng = \Carbon\Carbon::createFromFormat('d/m/Y', $data->date_recorded)->toDateString();
			$dateEng = \Carbon\Carbon::parse($dateEng)->format('d M Y');
		
			if(isset($image->image_path)) {
                $stampInfo = (self::getStampAbsolutePath($image->image_path));
            } else {
                $stampInfo = array();
            }
			$dateIslamic = $data->islamic_calender;
			$dateEnglish = $dateEng;
			
			$nameOfImg = $this->generalService->generateRandomString();
			$nameOfImg = $nameOfImg . '.png';

			$text = $dateIslamic;
			persian_log2vis($text);

			$text1 = $dateEnglish;
			persian_log2vis($text1);
			
			if ((int)$data->group_type == 2) {
				$im = imagecreatefromjpeg(public_path() . '/assets/client/images/sample2.jpg');
			} else {
				$im = imagecreatefromjpeg(public_path() . '/assets/client/images/sample1.jpg');
			}

			$white = imagecolorallocate($im, 255, 255, 255);
			$yellow = imagecolorallocate($im, 248, 255, 0);
			$bg_color = imagecolorallocate($im, 255, 255, 255);
			
			// Replace path by your own font path
			$DejaVuSans = public_path() . ('/assets/client/p21/DejaVuSans.ttf');
			$UbuntuBoldFont = public_path() . ('/assets/client/fonts/Ubuntu-B.ttf');

            if ((int)$data->group_type == 2) {
                // Add the text
                @imagettftext($im, 110, 0, 150, 800, $white, $DejaVuSans, $text);
                @imagettftext($im, 100, 0, 300, 1000, $white, $UbuntuBoldFont, $text1);
            } else {
                // Add the text
                @imagettftext($im, 110, 0, 150, 600, $white, $DejaVuSans, $text);
                @imagettftext($im, 100, 0, 300, 800, $white, $UbuntuBoldFont, $text1);
            }
			$stampBit = true;
			// Load the stamp and the photo to apply the watermark to
			try {
			    if (isset($stampInfo) && count($stampInfo) > 0) {
                    $stampName = $stampInfo['absolute_path'];
                    if ($stampInfo['is_png']) {
                        $stamp = imagecreatefrompng($stampName);
                    } else {
                        $stamp = imagecreatefromjpeg($stampName);
                    }
                } else {
                    $stampBit = false;
                }
			} catch (\Exception $e) {
				$stampBit = false;
				if(isset($image) && count($image) > 0) {
                    dump($e);
                    dd('Exception While Creating Stamp');
                }
			}
			
			if ($stampBit) {
				try {
					list($width, $height) = getimagesize($stampInfo['absolute_path']);
					if (!isset($width)) {
						$width = 200;
					}
					if (!isset($height)) {
						$height = 200;
					}
                    if ((int)$data->group_type == 2) {
                        imagecopyresampled($im, $stamp, 150, 1200, 0, 0, 1300, 200, $width, $height);
                    } else {
                        imagecopyresampled($im, $stamp, 150, 900, 0, 0, 1300, 200, $width, $height);
                    }
				} catch (\Exception $e) {
					dd($e);
				}
			}
			
			imagepng($im, "uploads/" . $nameOfImg);
			imagedestroy($im);
			
			return collect([
				'collect' => 'success',
				'name' => $nameOfImg
			]);
		} catch (\Exception $e) {
			dd($e);
		}
		
	}
	
	
	
}
