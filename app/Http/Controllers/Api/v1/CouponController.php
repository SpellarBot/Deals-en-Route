<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Transformer\CouponTransformer;
use App\Http\Services\ResponseTrait;
use Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller {

    use ResponseTrait;
    use \App\Http\Services\CouponTrait;

    protected function validatordetail(array $data) {
        return Validator::make($data, [
                    'coupon_id' => 'required',
        ]);
    }

    //coupon listing catgeory wise
    public function couponListCategoryWise(Request $request) {
        try {

            // get the request
            $data = $request->all();
            //add lat long if passsed to the data
            $user_detail = \App\UserDetail::saveUserDetail($data, Auth::user()->id);
            //find nearby coupon
            $couponlist = \App\Coupon::getNearestCoupon($data);
            if (count($couponlist) > 0) {
                $data = (new CouponTransformer)->transformList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_LIST'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    // coupon details
    public function couponDetail(Request $request) {
        try {

            // get the request
            $data = $request->all();
            $validator = $this->validatordetail($data);
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }
            //find nearby coupon
            $coupondetail = \App\Coupon::getCouponDetail($data);
            if (count($coupondetail) > 0) {
                $data = (new CouponTransformer)->transformDetail($coupondetail);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            //     throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function addFavourite(Request $request) {

        try {

            // get the request
            $data = $request->all();
            //find nearby coupon
            $coupondetail = \App\CouponFavourite::addFavCoupon($data);
            if ($coupondetail) {
                return $this->responseJson('success', \Config::get('constants.COUPON_ADD_FAV'), 200);
            }
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        } catch (\Exception $e) {
            // throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function couponFavList(Request $request) {
        try {
            // get the request
            $data = $request->all();

            //find nearby coupon
            
            $coupondetail = \App\CouponFavourite::getCouponFavList($data);
            if (count($coupondetail) > 0) {
                $data = (new CouponTransformer)->transformFavSearchList($coupondetail);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            //    throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function couponSearchList(Request $request) {
        try {
            // get the request
            $data = $request->all();
            //add lat long if passsed to the data
            $user_detail = \App\UserDetail::saveUserDetail($data, Auth::user()->id);

            //find nearby coupon
            $coupondetail = \App\Coupon::getNearestCoupon($data);
            if (count($coupondetail) > 0) {
                $data = (new CouponTransformer)->transformFavSearchList($coupondetail);
                return $this->responseJson('success', \Config::get('constants.COUPON_LIST'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function redeemCouponList(Request $request) {
        try {
            // get the request
            $data = $request->all();

            $couponlist = \App\CouponRedeem::redeemCouponList($data); 
            
            if (count($couponlist) > 0) {
                $data = (new CouponTransformer)->transformShareList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }
    
      public function shareCouponList(Request $request) {
        try {
            // get the request
            $data = $request->all();
        
            //find nearby coupon
            $couponlist = \App\CouponShare::couponShareList($data);
            
            if (count($couponlist) > 0) {
                $data = (new CouponTransformer)->transformShareList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }
    
   public function addRedeem(Request $request) {
        try {
            // get the request
            $data = $request->all();
        
            //find nearby coupon
            $redeem=new \App\CouponRedeem();
            $redeem->user_id=Auth::id();
            $redeem->coupon_id=$data['coupon_id'];
            $redeem->is_redeem=1;
      
            if ($redeem->save()) {
         
                if($this->getCouponShareCount('',$data['coupon_id'])>0){
             $activity= \App\Activity::redeemActivity($data,Auth::id());
                }
             return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

}
