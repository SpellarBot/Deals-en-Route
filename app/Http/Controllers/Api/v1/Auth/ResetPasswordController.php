<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Session;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
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
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postEmail(Request $request) {
         $data = $request->all();
         
        $validator = Validator::make($data, [
                    'email' => 'required'
        ],[
            'email.required' =>\Config::get('constants.USER_LOGIN_REQUIRED'),
        ]);

        if ($validator->fails()) {
            $validation = $validator->errors()->first();
            return response()->json(['status' => 'error', 'message' => $validation], 400);
        }

        $email = User::Where('email', $data['email'])->first();
        $array = (!empty($email)) ? ['email' => $email->email] : [];
        $response = $this->passwords->sendResetLink($array);

        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                return response()->json(['status' => 'success', 'message' => 'We have e-mailed you a Password Reset Link'], 200);


            case PasswordBroker::INVALID_USER:
                return response()->json(['status' => 'error', 'message' => 'we are Unable to find your E-Mail'], 400);

            //   return redirect()->back()->withErrors(['email' => trans($response)]);
        }
        
    }
    
    public function showResetForm(Request $request, $token = null,$email=null) {
      
        return view('api.resetpassword')->with(
                         ['email' => $email, 'token' => $token]
        );
    }
    
       /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postReset(Request $request) {
        $data=$request->all();    
      
        if (empty($data['email'])) {
            Session::flash('message',\Config::get('constants.USER_NOT_FOUND'));
            return redirect()->back();
        }
        $this->validate($request, [
            
            'token' => 'required',
             'password' => 'required|confirmed',
        ]);

       
        $token = \DB::table('password_resets')
                ->where('email', '=', $request->all()['email'])
                ->where('created_at', '>', Carbon::now()->subHours(1))
                ->first();
        if (empty($token)) {
            Session::flash('message', \Config::get('constants.TOKEN_EXPIRED'));
            return redirect()->back();
        } else {
             $credentials = $request->only(
                'email', 'password', 'password_confirmation', 'token'
        );
            $response = $this->passwords->reset($credentials, function($user, $password) {
                $user->password = $password;
                $user->save();
                $this->auth->login($user);
            });
        }
        switch ($response) {
            case PasswordBroker::PASSWORD_RESET:
                Auth::logout();
                  Session::flash('success', \Config::get('constants.USER_PASSWORD_SUCCESS'));
                return Redirect('/confirm');

            default:
                Session::flash('message', trans($response));
                return redirect()->back();
        }
    }
    
}
