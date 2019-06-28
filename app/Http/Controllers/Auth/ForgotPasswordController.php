<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\websiteConfiguration;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->configuration = new websiteConfiguration();
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return back()->with('status', __($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => __($response)]
        );
    }
	
		/**
		 * Display the form to request a password reset link.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function showLinkRequestForm()
		{
			$a = $this->configuration->getConfig();
			$theme = $a['website_theme'];
			if($theme == 'betube_light' || $theme == 'betube_dark') {
				$finder = new \Illuminate\View\FileViewFinder(app()['files'], array(resource_path('views/themes/betube')));
				\View::setFinder($finder);
				return view('client.forgotpassword');
			} else {
				return view('auth.passwords.email');
			}
			
		}
}
