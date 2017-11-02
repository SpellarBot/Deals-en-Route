<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginFormRequest;
use Session;
use Redirect;

class LoginController extends Controller {
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

use AuthenticatesUsers;
    use \App\Http\Services\ImageTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/frontend/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout', 'dashboard']);
    }

    public function index() {
        // show logo image
        $company_logo = $this->showLogoImage();
        return view('frontend.home')->with(['company_logo' => $company_logo]);
    }

    public function showLoginForm() {
        return view('frontend.auth.login');
    }

    public function logout() {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('web');
    }

    public function login(LoginFormRequest $request) {

        $data = $request->all();
        $email = $data['email'];
        $password = $data['password'];
        $credentials = ['email' => $email, 'password' => $password, 'role' => 'vendor'];
        if (Auth::guard('web')->attempt($credentials)) {
            $auth = Auth()->user();
            if ($auth->is_delete == 1) {
                Auth::guard('web')->logout();
                return response()->json(['status' => 0, 'errormessage' => ucwords(\Config::get('constants.USER_DELETE'))], 422);
            } else if ($auth->is_active == 0) {
                Auth::guard('web')->logout();
                return response()->json(['status' => 0, 'errormessage' => ucwords(\Config::get('constants.USER_DEACTIVE'))], 422);
            } else if ($auth->is_confirmed == 0) {
                Auth::guard('web')->logout();
                return response()->json(['status' => 0, 'errormessage' => ucwords(\Config::get('constants.USER_NOT_CONFIRMED'))], 422);
            } else {
                return true;
            }
        } else {
            return response()->json(['status' => 0, 'errormessage' => ucwords(trans('auth.failed'))], 422);
        }
    }

    public function dashboard() {
        return view('frontend.dashboard');
    }

    
     public function confirmvendor($confirmation_code) {

        try {
            $user = \App\User::whereConfirmationCode($confirmation_code)->first();

            if (!empty($user)) {
                if ($user->is_confirmed == 1) {
                    Session::flash('error', \Config::get('constants.EMAIL_ALREADY_CONFIRMED'));
                    return Redirect::to('/confirm');
                }
                $user->is_confirmed = 1;
                $user->confirmation_code = null;
                $user->save();
          
                if(Auth::guard('web')->loginUsingId($user->id)){
                Session::flash('success', \Config::get('constants.EMAIL_VERIFIED'));
                return Redirect::to('/dashboard');
                }        
                Session::flash('error', \Config::get('constants.APP_ERROR'));
                return Redirect::to('/confirm');
            }
            Session::flash('error', \Config::get('constants.EMAIL_CODE_EXPIRED'));
            return Redirect::to('/confirm');
        } catch (\Exception $e) {
        //    throw $e;
            Session::flash('error', \Config::get('constants.APP_ERROR'));
            return Redirect::to('/confirm');
        }
    }
}
