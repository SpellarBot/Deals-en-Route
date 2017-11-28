<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Services\ResponseTrait;
use App\Http\Services\MailTrait;
use App\VendorDetail;
use App\CouponCategory;
use App\User;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Services\ImageTrait;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;
use App\Http\Transformer\UserTransformer;
use App\Http\Transformer\VendorTransformer;
use Mail;

class VendorRegisterController extends Controller {
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
                    'vendor_name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:6',
                    'vendor_phone' => 'required|max:15|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
                    'vendor_logo' => 'sometimes|required|image|mimes:jpg,png,jpeg',
        ]);
    }

    protected function validatorupdate(array $data) {
        return Validator::make($data, [
                    'vendor_name' => 'sometimes|required|string|max:255',
                    'vendor_phone' => 'required|max:15|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
                    'vendor_logo' => 'sometimes|required|image|mimes:jpg,png,jpeg',
        ]);
    }

    protected function validatoremail(array $data) {
        return Validator::make($data, [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
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
    public function create(Request $request) {
        DB::beginTransaction();
        try {
// process the store
            $data = $request->all();
            $user_detail = VendorDetail::createVendorFront($data);
            $file = Input::file('vendor_logo');
//store image
            if (!empty($file)) {
                $this->addImageWeb($file, $user_detail, 'vendor_logo');
            }
            if ($user_detail) {
//stripe payment
                $stripeuser = \App\StripeUser::createStripeUser($user_detail->user_id);
                $stripeuser->createToken($data);
                Session::flash('success', \Config::get('constants.USER_EMAIL_VERIFICATION'));
            }
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {

            \App\StripeUser::findCustomer($data['email']);
            DB::rollback();

            $message = $e->getMessage();
            if (strpos($message, 'year') !== false || strpos($message, 'month') !== false) {
                return response()->json(['errors' => ['card_expiry' => [0 => ucwords($message)]]], 422);
            } elseif (strpos($message, 'cvv') !== false || strpos($message, 'security code') !== false) {
                return response()->json(['errors' => ['card_cvv' => [0 => ucwords($message)]]], 422);
            } elseif (strpos($message, 'number') !== false || strpos($message, 'card') !== false) {
                return response()->json(['errors' => ['card_no' => [0 => ucwords($message)]]], 422);
            }
            return response()->json(['status' => 0, 'message' => ucwords($message)], 422);
        } catch (\Cartalyst\Stripe\Exception\UnauthorizedExceptioncatch $e) {
//throw $e;
// \App\StripeUser::findCustomer($data['email']);
            DB::rollback();
            return response()->json(['status' => 0, 'message' => ucwords($e->getMessage())], 422);
        } catch (\Exception $e) {
//throw $e;
//    \App\StripeUser::findCustomer($data['email']);
            DB::rollback();
            return response()->json(['status' => 0, 'message' => ucwords($e->getMessage())], 422);
        }
// If we reach here, then// data is valid and working.//
        DB::commit();
        $array_mail = ['to' => $data['email'],
            'type' => 'verifyvendor',
            'data' => ['confirmation_code' => User::find($user_detail->user_id)->confirmation_code],
        ];
        $subscribe = $this->subscribe($user_detail->user_id, $data['pakage']);
        if ($subscribe == TRUE) {
//            $this->sendMail($array_mail);
            $data = (new VendorTransformer)->transformLogin($data);
            return $this->responseJson('success', \Config::get('constants.USER_EMAIL_VERIFICATION'), 200);
        } else {
//            $this->sendMail($array_mail);
            $data = (new VendorTransformer)->transformLogin($data);
            return $this->responseJson('success', \Config::get('constants.SUBSCRIPTION_ERROR'), 200);
        }
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
            $user = VendorDetail::updateVendor($data);
            $user_detail = \App\VendorDetail::saveVendorDetail($data, $user->id);

            if ($request->file('vendor_logo')) {
                $this->updateImage($request, $user_detail, 'vendor_logo');
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
        $data = (new VendorTransformer)->transformLogin($user);
        return $this->responseJson('success', \Config::get('constants.USER_UPDATED_SUCCESSFULLY'), 200, $data);
    }

//create subscription for customer 
    public function subscribe($user_id, $plan_id) {

        try {
            $stripeuser = \App\StripeUser::where('user_id', $user_id)->first();
            $user = \App\User::find($user_id);
            if (empty($stripeuser->userSubscription)) {
                $result = $stripeuser->createSubcription($plan_id);
                if ($result) {
                    return TRUE;
                }
            }
        } catch (\Exception $e) {
// throw $e;     
            return FALSE;
        }
// If we reach here, then// data is valid and working.//
    }

}
