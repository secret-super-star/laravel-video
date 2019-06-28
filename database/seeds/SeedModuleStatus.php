<?php

use App\Models\WebsiteModulesStatus;
use Illuminate\Database\Seeder;

class SeedModuleStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$modules = \App\Models\WebsiteModules::all();
	    $celebrityId = '';
	    $videoGroupId='';
	    $multipleVideo = '';
    	foreach ($modules as $key => $val) {
    		WebsiteModulesStatus::create([
    			 'status' => 1,
			     'module_id' => $val->id
		    ]);
	    }
			
    }
}
