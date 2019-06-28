<?php

namespace App\Http\Middleware;

use App\Services\GeneralServices;
use Closure;

class ModulesRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $action = $request->route()->action;
        $module = isset($action['module']) ? $action['module'] : '';

        $this->services = new GeneralServices();
        $modulesConfig = $this->services->getModuleConfig();
        $celebritycheck = false;
        $videocheck = false;
        if ($modulesConfig['status'] == 'success') {
            foreach($modulesConfig['data'] as $key => $val) {
                if($val->module_name == "Celebrities") {
                    if ((int)$val->modulesStatus->status == 1) {
                        $celebritycheck = true;
                    }
                }

                if($val->module_name == "Groups") {
                    if ((int)$val->modulesStatus->status == 1) {
                        $videocheck = true;
                    }
                }
            }
        }

        if($module == 'celebrity_module') {
            if(!$celebritycheck) {
                return redirect('/404');
            }
        }

        if($module == 'video_groups_module') {
            if(!$videocheck) {
                return redirect('/404');
            }
        }

        return $next($request);
    }
}
