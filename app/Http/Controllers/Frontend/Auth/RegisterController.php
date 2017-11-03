<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Redirect;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Services\ResponseTrait;
use App\Http\Services\ImageTrait;
use App\Http\Services\MailTrait;
use Auth;

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

    use RegistersUsers;
    use ImageTrait;
    use ResponseTrait;
     use MailTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $category_images;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(RegisterFormRequest $request) {
        DB::beginTransaction();
        try {
            // process the store
            $data = $request->all();
            $user_detail = \App\VendorDetail::createVendorFront($data);
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
            return response()->json(['status' => 1, 'errormessage' => ucwords($message)], 422);
        } catch(\Cartalyst\Stripe\Exception\UnauthorizedExceptioncatch $e) {
            //throw $e;
           // \App\StripeUser::findCustomer($data['email']);
            DB::rollback();
            return response()->json(['status' => 1, 'errormessage' => ucwords($e->getMessage())], 422);
        }
        catch (\Exception $e) {
            //throw $e;
            \App\StripeUser::findCustomer($data['email']);
            DB::rollback();
            return response()->json(['status' => 1, 'errormessage' => ucwords($e->getMessage())], 422);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
         $array_mail = ['to' => $data['email'],
                    'type' => 'verifyvendor',
                    'data' => ['confirmation_code' => User::find($user_detail->user_id)->confirmation_code],
                ];
         $this->sendMail($array_mail);
        // redirect
        return view('frontend.signup.pricetable')->with(['user_id' => $user_detail->user_id]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCategoryForm() {
        $company_logo = $this->showLogoImage();
        $category_images = \App\WebCouponCategory::categoryList();
        $signup_category_images = \App\CouponCategory::categoryListWeb();
        $country_list = \App\Country::countryList();

        return view('frontend.signup.category')->with(['company_logo' => $company_logo,
                    'category_images' => $category_images, 'signup_category_images' => $signup_category_images,
                    'country_list' => $country_list]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('web');
    }

    //create subscription for customer 
    public function subscribe(Request $request) {
   
        try {
            $request = $request->all();
            $stripeuser = \App\StripeUser::where('user_id', $request['user_id'])->first();
            if(!empty($stripeuser->userSubscription)){
            $result = $stripeuser->createSubcription($request['plan_id']);
            $user=\App\User::find($request['user_id']);  
            if ($result) {  
            if($user->is_confirmed==1){
                 Auth::guard('web')->loginUsingId($user->id);
                 Session::flash('success', \Config::get('constants.USER_LOGIN_SUCCESS'));
                 return response()->json(['status' => 1], 200);
            }else{
                Session::flash('success', \Config::get('constants.USER_EMAIL_VERIFICATION'));
                return response()->json(['status' => 0], 200);
            }
            }
            Session::flash('error', \Config::get('constants.APP_ERROR'));
            return response()->json(['status' => 0], 422);
            }
             Session::flash('error', \Config::get('constants.ALREADY_SUBCRIBE'));
            return response()->json(['status' => 1], 200);
        } catch (\Exception $e) {
           
            // throw $e;     
             Session::flash('error', \Config::get('constants.APP_ERROR'));
             return response()->json(['status' => 0], 422);
        }
        // If we reach here, then// data is valid and working.//
      
    }
    
    
     

}
