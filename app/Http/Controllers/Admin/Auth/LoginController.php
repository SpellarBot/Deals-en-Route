<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest.admin', ['except' => 'logout']);
    }

    public function showLoginForm() {
        return view('admin.auth.login');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('admin');
    }

    public function login(Request $request) {

        $data = $request->all();

        $rules = [
            'email' => 'required|max:255',
            'password' => 'required'
        ];

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            //login data not exist in db
            return redirect('/admin/login')->withErrors($validator)->withInput();
        } else {
            $email = $data['email'];
            $password = $data['password'];
            $credentials = ['email' => $email, 'password' => $password];
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect('/admin');
            } else {
                //not status 1 or active
                $validator->errors()->add('email', 'These credentials do not match our records.');
                return redirect('/admin/login')->withErrors($validator)->withInput();
            }
        }
    }

}
