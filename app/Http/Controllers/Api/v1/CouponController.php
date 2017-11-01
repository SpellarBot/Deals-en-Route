<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Transformer\CouponTransformer;
use App\Http\Services\ResponseTrait;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
use Notification;
use DB;
use URL;
use Carbon\Carbon;


class CouponController extends Controller {

    use ResponseTrait;
    use Notifiable;
    use \App\Http\Services\CouponTrait;
    use \App\Http\Services\ActivityTrait;

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
             return $this->responseJson('success', \Config::get('constants.COUPON_ADD_REDEEM'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }
    
    
    //cron job for new coupon
    public function   CouponNotificationNew(Request $request) {
        $newcouponuser = \App\User::where('role','user')
                  ->leftJoin('user_detail', 'user_detail.user_id', '=', 'users.id')
                 ->leftJoin('device_detail', 'device_detail.user_id', '=', 'users.id')
                ->where('latitude','!=','')
                ->where('longitude','!=','')
                ->where('device_token','!=','')
                ->where('notification_new_offer',1)
                ->get();

        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        
        foreach($newcouponuser as $newcouponusers) {
               
        $lat = $newcouponusers->latitude;
        $lng = $newcouponusers->longitude;
        $id = $newcouponusers->category_id;
       
        $idsArr = explode(',', $id);
        $couponlist = \App\Coupon::active()->deleted()
                ->select(DB::raw('coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,created_by,coupon_lat,'
                                . 'coupon_long,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat)))) ) as distance'))
                ->where(\DB::raw('TIMESTAMP(`coupon_start_date`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`coupon_end_date`)'), '>=', date('Y-m-d H:i:s'))
                ->whereColumn('coupon_total_redeem', '<', 'coupon_redeem_limit')
                ->havingRaw('coupon_radius >= distance')
                ->whereIn('coupon_category_id', $idsArr)
                ->get();
        foreach($couponlist as $couponlists){
           $checkUserNotifyNewOffer = $this->getUserNotificationOffer($newcouponusers->id, $couponlists->coupon_id, 'newoffer');
           if ($checkUserNotifyNewOffer <= 0) {
                // send notification
                Notification::send($newcouponusers, new FcmNotification([
                    'type' => 'newoffer',
                    'notification_message' => 'Hey {{to_name}}, you have new  deal on {{coupon_name}} !!',
                    'message' => 'Hey ' . $newcouponusers->first_name . ' ' . $newcouponusers->last_name . ' Your have new  deal on ' . $couponlists->coupon_name,
                    'name' => $newcouponusers->first_name . ' ' . $newcouponusers->last_name,
                    'image' => (!empty($couponlists->vendorDetail->vendor_logo)) ? URL::to('/storage/app/public/profile_pic') . '/' . $couponlists->vendorDetail->vendor_logo : "",
                    'coupon_id' => $couponlists->coupon_id
                ]));
            }
            
        }
      
      
        }
  
    }
     
    //cron job for coupon expiring
    public function   CouponNotificationFavExpire(Request $request) {
               $date = Carbon::now()->format('Y-m-d');
              
                $coupon = \App\CouponFavourite::
                        select(DB::raw('coupon.coupon_id,coupon_favourite.user_id,coupon.created_by,coupon_end_date,
                               DATE_SUB(coupon_end_date, INTERVAL 1 DAY)  as datesub'))
                        ->leftJoin('coupon', 'coupon_favourite.coupon_id', '=', 'coupon.coupon_id')
                        ->where('is_active', \App\CouponFavourite::IS_TRUE)
                        ->where('is_delete', \App\CouponFavourite::IS_FALSE)
                        ->having(\DB::raw('date_format(datesub,"%Y-%m-%d")'),"$date")
                        ->where('is_favorite', \App\CouponFavourite::IS_TRUE)
                        ->get()->toArray();
               
        foreach ($coupon as $coupons) {
            $to_id = \App\User::find($coupons['user_id']);
            $coupondetail = \App\Coupon::find($coupons['coupon_id']);
            $checkUserNotify = $this->getUserNotification($to_id->id, $coupons['coupon_id'], 'favexpire');

            if ($checkUserNotify <= 0 && $to_id->userDetail->notification_fav_expire==1) {

                // send notification
                Notification::send($to_id, new FcmNotification([
                    'type' => 'favexpire',
                    'notification_message' => 'Hey {{to_name}}, Your Favorite deal on {{coupon_name}} expiring soon! Redeem before it goes away!!',
                    'message' => 'Hey ' . $to_id->userDetail->first_name . ' ' . $to_id->userDetail->last_name . ' Your Favorite deal on ' . $coupondetail->coupon_name . ' expiring soon! ',
                    'name' => $to_id->first_name . ' ' . $to_id->last_name,
                    'image' => (!empty($coupondetail->vendorDetail->vendor_logo)) ? URL::to('/storage/app/public/profile_pic') . '/' . $coupondetail->vendorDetail->vendor_logo : "",
                    'coupon_id' => $coupons['coupon_id']
                ]));
            }
        }
  
    }
    
    
     
   
    
}
