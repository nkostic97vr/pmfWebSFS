<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Helpers\Logger;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        redirectPath as laravelRedirectPath;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
       $login = request()->input('email');
       $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
       request()->merge([$field => $login]);
       return $field;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (captcha_set()) {
            if (!validate_captcha($request->{'g-recaptcha-response'}, $request->ip())) {
                Logger::log('error', __METHOD__, $request->ip() . ' has failed captcha.');
                return alert_redirect(url()->previous(), 'error', __('auth.captcha-failed'));
            }
        }

        if ($user = User::where($this->username(), $request[$this->username()])->first()) {
            if (is_empty($user->email_token)) {
                if ($this->attemptLogin($request)) {
                    return $this->sendLoginResponse($request);
                }
            }
        }

        $this->incrementLoginAttempts($request);

        return ($user && is_not_empty($user->email_token)) ?
            alert_redirect(url()->previous(), 'error', __('auth.not-confirmed')) :
            alert_redirect(url()->previous(), 'error', __('auth.failed'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->back();
    }

}
