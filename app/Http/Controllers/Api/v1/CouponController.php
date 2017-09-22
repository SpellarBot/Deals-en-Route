<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Transformer\CouponTransformer;
use App\Http\Services\ResponseTrait;
use Auth;
class CouponController extends Controller {
    
    

    use ResponseTrait;
    
     
    public function couponListCategoryWise(Request $request) {
        try {
            $role = Auth::user()->role;
            if ($role != 'user') {
                return $this->responseJson('error', \Config::get('constants.NOT_AUTHORIZED'), 400);
            }
            // get the request
            $data = $request->all();
            //find nearby coupon
            $couponlist = \App\Coupon::getNearestCoupon($data);
            if (count($couponlist) > 0) {
                $data = (new CouponTransformer)->transformList($couponlist);
                return $this->responseJson('success', \Config::get('constants.CATEGORY_SAVE'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

}
