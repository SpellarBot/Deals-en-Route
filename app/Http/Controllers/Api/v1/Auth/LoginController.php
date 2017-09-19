<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Services\UserTrait;
use App\Http\Services\ResponseTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Transformer\UserTransformer;


class LoginController extends Controller {

    use ResponseTrait;
    use UserTrait;
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
  //  protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       // $this->middleware('guest')->except('logout');
    }

    protected function validatormanually(array $data) {
        return Validator::make($data, [
                    'email' => 'required',
                    'password' => 'required',
        ]);
    }

    public function login(Request $request) {
        $data = $request->all();
        $validator = $this->validatormanually($data);
        if ($validator->fails()) {
            return $this->responseJson('error', $validator->errors()->first(), 400);
        }
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            $auth = Auth()->user();
            if ($auth->is_confirmed == 0) {
                return $this->responseJson('error', \Config::get('constants.USER_NOT_CONFIRMED'), 422);
            }
            $auth->api_token = $this->generateAuthToken();
            $auth->save();
            // Authentication passed...
            $data = (new UserTransformer)->transformLogin($auth);
            return $this->responseJson('error', \Config::get('constants.USER_LOGIN'), 200, $data);
        }
        return $this->responseJson('error', trans('auth.failed'), 422);
    }
    

    public function addUserDetail(Request $request) {
        $data = $request->all();
         $auth = Auth()->user();
        $userdetail= \App\UserDetail::find($auth->id);
        $userdetail->fill($data);
        if(isset($data['is_notification']) && !empty($data['is_notification'])){
        $userdetail->notification_new_offer= $data['is_notification'];
        $userdetail->notification_recieve_offer =$data['is_notification'];
        }
        $auth->fill($data);
        if($userdetail->save() && $auth->save() ){
           return $this->responseJson('success', \Config::get('constants.USER_UPDATE_PROFILE'), 200); 
        }
          return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);            
    }

}
