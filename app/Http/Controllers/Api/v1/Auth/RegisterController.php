<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Services\ResponseTrait;
use App\Http\Services\MailTrait;
use App\User;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Services\ImageTrait;
use Intervention\Image\Facades\Image as Image;
use App\Http\Transformer\UserTransformer;

class RegisterController extends Controller {
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

    use ResponseTrait;
    use MailTrait;
    use RegistersUsers;
    use ImageTrait;
    

    CONST IS_CONFIRMED = 1;
    CONST IS_NOT_CONFIRMED = 0;

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
    public function __construct() {
        //     $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatormanually(array $data) {
        return Validator::make($data, [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    'phone' => 'required|max:15|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
                    'device_type' => 'sometimes|required',
                    'device_version' => 'sometimes|required',
                    'app_version' => 'sometimes|required',
                    'profile_pic' => 'sometimes|required|image|mimes:jpg,png,jpeg|max:20000',
        ]);
    }
    
     protected function validatorupdate(array $data) {
        return Validator::make($data, [
                    'first_name' => 'sometimes|required|string|max:255',
                    'last_name' => 'sometimes|required|string|max:255',
                    'password' => 'sometimes|required|string|min:6',
                   'mobile_no' => 'sometimes|required|min:6|max:20',
                   'name' => 'sometimes|required',
                   'profile_pic' => 'sometimes|required|image|mimes:jpg,png,jpeg|max:20000',
        ]);
     }

    /**
     * @SWG\Post(
     *   path="/user/register",
     *   summary="register user",
     *   operationId="create",
     *   @SWG\Parameter( name="first_name", in="query",  required=true,  type="string" ),
     *   @SWG\Parameter( name="last_name", in="query",  required=true,  type="string" ),
     *   @SWG\Parameter( name="email", in="query",  required=true,  type="string" ),
     *   @SWG\Parameter( name="phone", in="query",  required=true,  type="string" ),
     *   @SWG\Parameter( name="device_token", in="query",  required=true,  type="string" ),
     *   @SWG\Parameter( name="password", in="query",  required=true,  type="string" ),
     *   @SWG\Parameter( name="app_version", in="query",  required=false,  type="string" ),
     *   @SWG\Parameter( name="device_type", in="query",  required=false,  type="string" ),
     *   @SWG\Parameter( name="device_version", in="query",  required=false,  type="string" ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     *
     */
    protected function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = $request->all();
            $validator = $this->validatormanually($data);
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }

            $user_id = User::creatUser($data);
            if ($user_id) {
                $array_mail = ['from' => 'jinal@solulab.com', 'to' => $data['email'],
                    'subject' => 'Verify your email address', 'template' => 'email.verify',
                    'data' => ['email_content' => 'Verify your email address', 'confirmation_code' => $user_id->confirmation_code]
                ];
                $this->sendMail($array_mail);
                $user_detail = \App\UserDetail::saveUserDetail($data, $user_id->id);
                if ($request->file('profile_pic')) {
                    $this->addImage($request, $user_detail, 'profile_pic');
                }
                \App\DeviceDetail::saveDeviceToken($data, $user_id->id);
            }
            // save the user
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        return $this->responseJson('success', \Config::get('constants.USER_EMAIL_VERIFICATION'), 200);
    }

    
    //update the profile 
    
    protected function update(Request $request) {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $validator = $this->validatorupdate($data);
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }
            $user=User::updateUser($data);    
            $user_detail = \App\UserDetail::saveUserDetail($data, $user->id);
                
            if ($request->file('profile_pic')) {
               
                $this->updateImage($request, $user_detail, 'profile_pic');
            }
       
            \App\DeviceDetail::saveDeviceToken($data, $user->id);

            // save the user
        } catch (\Exception $e) {
            DB::rollback();
          //  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
            $data = (new UserTransformer)->transformLogin($user);
            return $this->responseJson('success', \Config::get('constants.USER_UPDATED_SUCCESSFULLY'), 200, $data);

    }

}
