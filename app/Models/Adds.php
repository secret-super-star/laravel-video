<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adds extends Model
{
	protected $table = 'adds';
	
	protected $fillable = [
		'add1',
		'add2',
		'add3'
	];
	
	public function saveAdd($request)
	{
		$this->truncate();
		return $this->create([
			'add1' => $request->add1,
			'add2' => $request->add2,
			'add3' => $request->add3
		]);
	}
}
