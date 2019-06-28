<?php

namespace App\Providers;

use App\Models\Auth\User\User;
use App\Policies\Backend\BackendPolicy;
use App\Policies\Models\User\UserPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        /**
         * Models Policies
         */
        User::class => UserPolicy::class,
        /**
         * Without models policies
         */
        'backend' => BackendPolicy::class,
		    /**
		     * Passport Class
		     * */
	      'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
   	    Passport::tokensExpireIn(Carbon::now()->addDays(15));
	      Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
 	
    }
}
