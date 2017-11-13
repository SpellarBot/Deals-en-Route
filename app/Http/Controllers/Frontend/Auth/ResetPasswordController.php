<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Session;

class ResetPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;

      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords, PasswordBroker $token) {
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->token = $token;

        // $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null) {
        return view('admin.auth.passwords.reset')->with(
                        ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('admins');
    }
    
    

    /**
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postEmail(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
                    'email' => 'required'
                        ], [
                    'email.required' => \Config::get('constants.USER_LOGIN_REQUIRED'),
        ]);

        if ($validator->fails()) {
            $validation = $validator->errors()->first();
            return response()->json(['status' => 'error', 'message' => $validation], 400);
        }

        $email = User::Where('email', $data['email'])->Where('role', 'vendor')->first();
        $array = (!empty($email)) ? ['email' => $email->email] : [];
        $response = $this->passwords->sendResetLink($array);

        switch ($response) {
          
            case PasswordBroker::RESET_LINK_SENT:
                Session::flash('success', \Config::get('constants.USER_PASSWORD_RESET'));
                return response()->json(['status' => 'success'], 200);


            case PasswordBroker::INVALID_USER:
                return response()->json(['status' => 'error', 'message' => \Config::get('constants.USER_PASSWORD_FETCH')], 400);

            //   return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

}
