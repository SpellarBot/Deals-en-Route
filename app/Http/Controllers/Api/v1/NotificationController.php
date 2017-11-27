<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Services\ResponseTrait;
use App\Http\Services\CouponTrait;
use \App\Http\Services\NotificationTrait;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use App\Notifications\FcmNotification;
use Notification;
use DB;
use Carbon\Carbon;
use App\Coupon;
use App\User;
use Url;

class NotificationController extends Controller {

    use ResponseTrait;
    use CouponTrait;

    // coupon geo notification
    public function couponGeoNotification(Request $request) {
        try {
            $request = $request->all();
             
           
                $validator = Validator::make($request, [
                            'latitude' => 'required',
                            'longitude' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->responseJson('error', $validator->errors()->first(), 400);
                } 
                \App\UserDetail::saveUserDetail($request,Auth::id());
                $usernotify = User::find(Auth::id())->userDetail->notification_new_offer;
                 if ($usernotify == 1) {
                $couponlist = Coupon::getCouponAllList();
                foreach ($couponlist as $key => $value) {

                    $xAxis = '';
                    $yAxis = '';
                    $checkUserNotifyGeoOffer = $this->getUserNotificationOffer(Auth::id(), $value['coupon_id'], 'geonotification');
 
                    if ($checkUserNotifyGeoOffer <= 0) {

                        $jsonDecode = json_decode($value['coupon_notification_point']);

                        foreach ($jsonDecode as $keyJson => $valueJson) {
                            $xAxis[] = $valueJson->lat;
                            $yAxis[] = $valueJson->lng;
                        }

                        $verticesX = $xAxis;    // x-coordinates of the vertices of the polygon
                        $verticesY = $yAxis;
                        $pointsPolygon = count($verticesX);  // number vertices - zero-based array
                        $longitudeX = $request['latitude'];  // x-coordinate of the point to test
                        $latitudeY = $request['longitude'];    // y-coordinate of the point to test
                        $isPolygon = self::is_in_polygon($pointsPolygon, $verticesX, $verticesY, $longitudeX, $latitudeY);

                        if ($isPolygon) {
                                
                            $coupon = Coupon::where('coupon_id', $value['coupon_id'])->first();
                            $rand = rand(0, 5);
                            $nMessage = \Config::get('constants.NOTIFY_GEO')[$rand];
                            $fMessage = $coupon->finalNotifyMessage(Auth::id(), Auth::id(), $coupon, $nMessage);
                            // send notification
                            Notification::send(Auth::user(), new FcmNotification([
                                'type' => 'geonotification',
                                'notification_message' => $nMessage,
                                'message' => $fMessage,
                                'coupon_id' => $coupon->coupon_id,
                            ]));
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

     //cron job for coupon expiring
    public function CouponNotificationFavExpire(Request $request) {
        
         $couponlist = \App\CouponFavourite::getCouponAllFavExpire();

        foreach ($couponlist as $couponlists) {
            $to_id = \App\User::find($couponlists['user_id']);
            $coupondetail = \App\Coupon::find($couponlists['coupon_id']);
            $checkUserNotify = $this->getUserNotification($couponlists['user_id'], $couponlists['coupon_id'], 'favexpire');

            if ($checkUserNotify <= 0) {

                // send notification
                Notification::send($to_id, new FcmNotification([
                    'type' => 'favexpire',
                    'notification_message' => \Config::get('constants.NOTIFY_FAV_EXPIRE_5'),
                    'message' => \Config::get('constants.NOTIFY_FAV_EXPIRE_5'),
                   'coupon_id' => $couponlists['coupon_id']
                ]));
            }
        }
        
    


    }
    
    //cron job for coupon expiring
    public function CouponNotificationFavLeft(Request $request) {
  
         $couponlist = \App\CouponFavourite::getCouponAllFavListLimit();

        foreach ($couponlist as $couponlists) {
            $to_id = \App\User::find($couponlists['user_id']);
            $coupondetail = \App\Coupon::find($couponlists['coupon_id']);
            $checkUserNotify = $this->getUserNotification($couponlists['user_id'], $couponlists['coupon_id'], 'favleft');

            if ($checkUserNotify <= 0) {

                // send notification
                Notification::send($to_id, new FcmNotification([
                    'type' => 'favleft',
                    'notification_message' => \Config::get('constants.NOTIFY_FAV_EXPIRE_5'),
                    'message' => \Config::get('constants.NOTIFY_FAV_EXPIRE_5'),
                   'coupon_id' => $couponlists['coupon_id']
                ]));
            }
        }
    }
    
    
    public static function is_in_polygon($pointsPolygon, $verticesX, $verticesY, $longitudeX, $latitudeY) {
        $i = $j = $c = 0;
        for ($i = 0, $j = $pointsPolygon - 1; $i < $pointsPolygon; $j = $i++) {
            if ((($verticesY[$i] > $latitudeY != ($verticesY[$j] > $latitudeY)) &&
                    ($longitudeX < ($verticesX[$j] - $verticesX[$i]) * ($latitudeY - $verticesY[$i]) / ($verticesY[$j] - $verticesY[$i]) + $verticesX[$i])))
                $c = !$c;
        }
        return $c;
    }

}
