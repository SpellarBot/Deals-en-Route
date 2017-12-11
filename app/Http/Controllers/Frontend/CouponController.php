<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Services\ImageTrait;
use Auth;

class CouponController extends Controller
{
     use ImageTrait;
    
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth.vendor');
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
                    'profile_pic' => 'sometimes|required|image|mimes:jpg,png,jpeg',
        ]);
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
   
        $coupon = Coupon::where(['coupon_id' => $id])->first();
        $coupon->is_delete = Coupon::IS_TRUE;
        if($coupon->save()){
        return response()->json(['status'=>1,'message' => ucwords(\Config::get('constants.COUPON_DELETE'))], 200);
        }
       return response()->json(['status'=>0,'message' => ucwords(\Config::get('constants.APP_ERROR'))], 422);
    }
    
    
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\CouponRequest $request) { 
        DB::beginTransaction();
        try {
         $request = $request->all();
       
        if(!empty($request['validationcheck']) && $request['validationcheck']==1){
           
           $coupon=Coupon::addCoupon($request);
           $file = Input::file('coupon_logo');
            //store image
            if (!empty($file)) {
               $this->addImageWeb($file, $coupon, 'coupon_logo');
            }
            
        }
            // save the user
        } catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['status'=>0,'message' => \Config::get('constants.APP_ERROR')], 400);   
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        if(isset($coupon) && $coupon==true ){
        return response()->json(['status'=>1,'message' => \Config::get('constants.COUPON_CREATE')], 200);
        }
    }
    
    
    
     /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
      
         $id= base64_decode($id);
        $coupon_lists=\App\Coupon::couponList();
         $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->where('vendor_detail.user_id', Auth::id())
                ->first();
        $user_access=$vendor_detail->userSubscription;
        
        $coupon = Coupon::where('coupon_id',$id)->first();
        $start_date=$coupon->convertDateInUserTZ($coupon->coupon_start_date);
        $end_date=$coupon->convertDateInUserTZ($coupon->coupon_end_date);      
        return view('frontend.coupon.edit')->with(['coupon' => $coupon,
            'coupon_lists'=>$coupon_lists,'vendor_detail'=>$vendor_detail,
            'start_date_converted'=>$start_date,'end_date_converted'=>$end_date,
            'user_access'=>$user_access[0]]);
    }
    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\CouponRequest $request) {

        DB::beginTransaction();
        try {
            // process the store
            $data = $request->all();
          if(!empty($request['validationcheck']) && $request['validationcheck']==1){
             $id= $data['coupon_id'];
          
           $coupon=Coupon::updateCoupon($data,$id);
           $file = Input::file('coupon_logo');
            //store image
            if (!empty($file)) {
               $this->addImageWeb($file, $coupon, 'coupon_logo');
            }
        }
            
        } catch (\Exception $e) {
            DB::rollback();
           //  throw $e;
            return response()->json(['status'=>0,'message' => \Config::get('constants.APP_ERROR')], 400);   
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        if(isset($coupon) && $coupon==true ){
        return response()->json(['status'=>1,'message' => \Config::get('constants.COUPON_UPDATE')], 200);
        }
    }
    
}
