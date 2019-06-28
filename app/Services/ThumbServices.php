<?php

namespace App\Services;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;


/**
 * Created by PhpStorm.
 * User: ahsan
 * Date: 27/09/16
 * Time: 12:44 PM
 */
class ThumbServices implements FilterInterface
{
	public function applyFilter(Image $image)
	{
		return $image->resize(268, 190);
	}
}
