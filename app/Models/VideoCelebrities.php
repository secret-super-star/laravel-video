<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCelebrities extends Model
{
    protected $fillable = [
      'series_id',
	    'celebrities_id'
    ];
}
