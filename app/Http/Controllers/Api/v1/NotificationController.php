<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Services\ResponseTrait;
use \App\Http\Services\CouponTrait;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use App\Notifications\FcmNotification;
use Notification;
use DB;
use Carbon\Carbon;
use App\Coupon;
use App\User;

class NotificationController extends Controller {

    use CouponTrait;
    use ResponseTrait;

    // coupon geo notification
    public function couponGeoNotification(Request $request) {
        $request = $request->all();

        $usernotify = User::find(Auth::id())->userDetail->notification_new_offer;
        if ($usernotify == 1) {
            $validator = Validator::make($request, [
                        'lat' => 'required',
                        'long' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }
            $couponlist = Coupon::getCouponAllList();
            $xaxis = [];
            $yaxis = [];

            foreach ($couponlist as $key => $value) {
                $jsondecode = json_decode($value['coupon_notification_point']);
                foreach ($jsondecode as $keyjson => $valuejson) {
                    $xaxis[] = $valuejson->lat;
                    $yaxis[] = $valuejson->lat;
                }

                $vertices_x = $xaxis;    // x-coordinates of the vertices of the polygon
                $vertices_y = $yaxis;
                $points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
                $longitude_x = $request['lat'];  // x-coordinate of the point to test
                $latitude_y = $request['long'];    // y-coordinate of the point to test

                if (self::is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)) {
                    $coupon = Coupon::where('coupon_id', $value['coupon_id'])->first();

                    // send notification
                    Notification::send(Auth::user(), new FcmNotification([
                        'type' => 'geonotification',
                        'notification_message' => '{{vendor_name}} is offering deal around you.',
                        'message' => $coupon->vendorDetail->vendor_name . ' is offering deal around you.',
                        'coupon_id' => $coupon->coupon_id,
                    ]));
                }
            }
        }
    }

    public static function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y) {
        $i = $j = $c = 0;
        for ($i = 0, $j = $points_polygon; $i < $points_polygon; $j = $i++) {
            if ((($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
                    ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i])))
                $c = !$c;
        }
        return $c;
    }

}
