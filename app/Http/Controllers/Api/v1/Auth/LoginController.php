<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\Controller;
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

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    
      protected function validatormanually(array $data) {
        return Validator::make($data, [
                 'username' => 'required',
                  'password' => 'required',
        ]);
    }
    
     public function login(Request $request){
     $data=$request->all();
       $validator = $this->validatorlogin($data);
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 422);
            }
      if (Auth::attempt(['email' => $data['username'], 'password' => $data['password']]) ||
                Auth::attempt(['username' => $data['username'], 'password' => $data['password']]) ||
                        Auth::attempt(['mobile_no' => $data['username'], 'password' => $data['password']])
               ) {
          
      }
        
    }
}
