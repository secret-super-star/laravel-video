<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteModules extends Model
{
	protected $table = 'website_modules';

    public function modulesStatus()
    {
        return $this->hasOne('App\Models\WebsiteModulesStatus', 'module_id', 'id');
    }

    public function getModules()
    {
        return $this->with('modulesStatus')->get();
    }
    
    public function getSingleModules($name)
    {
        return $this
	        ->where('module_name', '=', $name)
	        ->with('modulesStatus')->first();
    }
}
