<?php

namespace App\Http\Controllers\Admin\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Redirect;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use \App\Http\Services\UserTrait;
    use \App\Http\Services\MailTrait;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
       /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admins');
    }
    
       public function confirm($confirmation_code) {

        try {
            $user = User::whereConfirmationCode($confirmation_code)->first();
           
            if (!empty($user)) {
                 if($user->is_confirmed==1){
                   Session::flash('error', \Config::get('constants.EMAIL_ALREADY_CONFIRMED'));
                   return Redirect::to('/confirm');
                 }
                $user->is_confirmed = 1;
                $user->confirmation_code = null;
                $user->api_token = $this->generateAuthToken();
                if($user->userDetail->type!=0 && empty($user->password)){
                     $password = $this->generatePassword();
                    $array_mail = ['to' => $user->email,
                        'type' => 'password',
                        'data' => ['password' => $password]
                    ];

                $this->sendMail($array_mail);
                $user->password = bcrypt($password);
                }
                $user->save();
                Session::flash('success', \Config::get('constants.EMAIL_VERIFIED'));
                return Redirect::to('/confirm');
                
            }
            Session::flash('error', \Config::get('constants.EMAIL_CODE_EXPIRED'));
            return Redirect::to('/confirm');
        } catch (\Exception $e) {
            throw $e;
            Session::flash('error', \Config::get('constants.APP_ERROR'));
            return Redirect::to('/confirm');
        }
    }
}
