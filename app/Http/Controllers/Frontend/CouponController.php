<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Session;

class CouponController extends Controller
{
    
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth.vendor');
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
    
}
