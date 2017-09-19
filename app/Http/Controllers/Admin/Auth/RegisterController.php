<?php

namespace App\Http\Controllers\Admin\Auth;

use App\User;
use App\Http\Controllers\Admin\Controller;
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
    
       public function confirm($confirmation_code) {

        try {
            $user = User::whereConfirmationCode($confirmation_code)->first();
           
            if (!empty($user)) {

                $user->is_confirmed = 1;
                $user->confirmation_code = null;
                $user->save();
                if($user->userDetail->type==0){
                $array_mail = ['to' => $user->email,
             'subject' => 'Password Generated', 'template' => 'email.password',
             'confirmation_code' => $user_id->confirmation_code];
              $this->sendMail($array_mail);
                }
                Session::flash('success', \Config::get('constants.EMAIL_VERIFIED'));
                return Redirect::to('/confirm');
                
            }
            Session::flash('error', \Config::get('constants.EMAIL_ALREADY_CONFIRMED'));
            return Redirect::to('/confirm');
        } catch (\Exception $e) {
          //  throw $e;
            Session::flash('error', \Config::get('constants.APP_ERROR'));
            return Redirect::to('/confirm');
        }
    }
}
