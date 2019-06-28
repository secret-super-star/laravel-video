<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteModulesStatus extends Model
{

    protected $table = 'website_modules_status';

    protected $fillable = [
      'module_id',
      'status'
    ];

    public function setupModules($celebrityId, $videoGroupId, $multipleVideo, $request)
    {
        $this->truncate();
        $input = ([
            'module_id' => $celebrityId,
            'status' => isset($request->celebrity) ? 1 : 0,
        ]);
        $this->create($input);
        $input = ([
            'module_id' => $videoGroupId,
            'status' => isset($request->groups) ? 1 : 0,
        ]);
        $this->create($input);
        $input = ([
            'module_id' => $multipleVideo,
            'status' => isset($request->multiple_videos) ? 1 : 0,
        ]);
        $this->create($input);
        return collect([
           'status' => true
        ]);
    }
}
