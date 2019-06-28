<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\SocialLogin;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\SocialAccount;
use App\Models\Auth\User\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Socialite;

class SocialLoginController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get the guard to be used during socail login.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        /** @var  $user User */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'image' => $data['image'],
            'password' => bcrypt(Uuid::uuid4()),
            'confirmation_code' => Uuid::uuid4(),
            'confirmed' => true,
            'active' => true
        ]);

        if (config('auth.users.default_role')) {
            $user->roles()->attach(Role::firstOrCreate(['name' => config('auth.users.default_role')]));
        }

        return $user;
    }

    /**
     * Redirect user to provider
     *
     * @param $provider
     * @return mixed
     */
    public function redirect($provider)
    {
        $socialite = Socialite::driver($provider);
	
        $scopes = config('services.' . $provider . '.scopes');
        $with = config('services.' . $provider . '.with');
        $fields = config('services.' . $provider . '.fields');

        if ($scopes) $socialite->scopes($scopes);
        if ($with) $socialite->with($with);
        if ($fields) $socialite->fields($fields);

        return $socialite->redirect();
    }

    /**
     * Social login
     */
    public function login($provider)
    {
        $socialite = Socialite::driver($provider);

        $socialUser = $socialite->user();
				$avatar = $socialUser->avatar;
        $user = null;

        $account = SocialAccount::whereProvider($provider)
            ->whereProviderId($socialUser->id)
            ->first();

        if ($account) {

            $account->token = $socialUser->token;
            $account->avatar = $socialUser->avatar;
            $account->save();

            $user = $account->user;
        }

        if (!$user) {
        	$name = $socialUser->name;
						$user = new User();
						$validUsr = $user->where('name', '=', $socialUser->name)->first();
						if (count($validUsr) > 0) {
							$name = 'usr'.$this->generateRandomString(5);
						}
            $account = new SocialAccount([
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'token' => $socialUser->token,
                'avatar' => $socialUser->avatar,
            ]);

            // User email may not provided.
            $email = $socialUser->email ?: $socialUser->id . '@' . $provider . '.com';

            $user = User::whereEmail($email)->first();

            if (!$user) $user = $this->create(['name' => $name, 'email' => $email, 'image' => $avatar]);

            $account->user()->associate($user);
            $account->save();
        }

        //disable login with social auth form admin
        if (config('auth.socialite.except_roles') && $user->hasRoles(config('auth.socialite.except_roles'))) {
            return redirect(route('login'))->withErrors([app(LoginController::class)->username() => __('auth.social')]);
        }

        session([config('auth.socialite.session_name') => $provider]);

        //fire social login event
        event(new SocialLogin($user, $provider, $socialite));

        $this->guard()->login($user);

        return $this->sendLoginResponse();
    }

    /**
     * Send the response after the user was social authenticated.
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse()
    {
        return $this->socialAuthenticated($this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated by social.
     *
     * @param  mixed $user
     * @return mixed
     */
    protected function socialAuthenticated($user)
    {

    }
	
	
		protected function  generateRandomString($length = 5) {
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		
}
