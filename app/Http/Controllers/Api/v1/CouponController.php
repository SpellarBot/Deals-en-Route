<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

class CouponController extends Controller {

    public function couponListCategoryWise(Request $request) {
        try {
            // get the request
            $data = $request->all();
            //find nearby coupon
            $couponlist = \App\Coupon::getNearestCoupon();
            if($couponlist>0){
            $data = (new CouponTransformer)->transformList($categoryListData);   
             return $this->responseJson('success', \Config::get('constants.CATEGORY_SAVE'), 200,
             $data);
            }
           return $this->responseJson('error', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
           
           throw $e;
           return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
           
        }
    }

}
