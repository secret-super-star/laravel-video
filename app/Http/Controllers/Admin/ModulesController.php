<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebsiteModules;
use App\Models\WebsiteModulesStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModulesController extends Controller
{
    public function __construct()
    {
        $this->modules = new WebsiteModules();
        $this->modulesStatus = new WebsiteModulesStatus();
    }

    public function index()
    {
        return view('admin.configuration.modules',[
            'modules' => $this->modules->getModules()
        ]);
    }

    public function setupModules(Request $request)
    {
        \DB::transaction(function () use ($request) {
           $celebrityModuleId = $this->modules->where('module_name', '=', 'Celebrities')->first();
           $VideoGroupsModuleId = $this->modules->where('module_name', '=', 'Groups')->first();
           $multipleVideo = $this->modules->where('module_name', '=', 'Multi Source')->first();
           $this->modulesStatus->setupModules($celebrityModuleId->id, $VideoGroupsModuleId->id, $multipleVideo->id, $request);
        });
        return redirect()->back();
    }
}
