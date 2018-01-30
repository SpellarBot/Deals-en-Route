<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Transformer\CouponTransformer;
use App\Http\Services\ResponseTrait;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
use App\Notifications;
use App\StripeUser;
use App\VendorDetail;
use App\User;
use Notification;
use DB;
use URL;
use Carbon\Carbon;
use App\Commision;
use App\PaymentInfo;
use App\Http\Services\PdfTrait;
use Mail;
use Illuminate\Support\Facades\Storage;
use App\DealLikes;
use App\DealComments;
use App\VendorRating;
use App\Http\Transformer\VendorTransformer;
use App\VendorHours;

class VendorController extends Controller {

    use ResponseTrait;
    use PdfTrait;
    use Notifiable;
    use \App\Http\Services\CouponTrait;
    use \App\Http\Services\ActivityTrait;
    use \App\Http\Services\MailTrait;

    public function vendorRating(Request $request) {
        $data = $request->all();
        $ratings = VendorRating::addRating($data);
        if ($ratings) {
            return $this->responseJson('success', \Config::get('constants.VENDOR_RATING'), 200);
        } else {
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function getVendorRatingsDetails(Request $request) {
        try {
            $data = $request->all();
            $vendorRatings = VendorRating::getRatingsDetails($data['vendor_id']);
            $vendorDetails = VendorDetail::getVendorDetails($data['vendor_id']);
            $data['vendor_details'] = (new VendorTransformer())->transformvendorData($vendorDetails->getAttributes());
            $data['ratings'] = [];
            $rates = 0;
            foreach ($vendorRatings as $rating) {
                $userdetails = $rating->getAttributes();
                $dt = new Carbon($userdetails['updated_at']);
                $ratingdetails['user_name'] = $userdetails['first_name'] . ' ' . $userdetails['last_name'];
                $ratingdetails['user_rating'] = $userdetails['rating'];
                $ratingdetails['user_comments'] = $userdetails['comments'];
                $ratingdetails['rating_date'] = $dt->toFormattedDateString();
                $ratingdetails['user_profile_pic'] = ($userdetails['profile_pic'] ? asset('storage/app/public/profile_pic/' . $userdetails['profile_pic']) : asset('storage/app/public/vendor_logo/'));
                $rates = $rates + $userdetails['rating'];
                array_push($data['ratings'], $ratingdetails);
            }
            $data['vendor_details']['total_ratings'] = ($rates == 0 ? 0 : number_format($rates / 5, 1));
            $hoursofOperations = VendorHours::getHoursOfOperations($data['vendor_id']);
            $data['vendor_details']['hours_of_operations'] = [];
            foreach ($hoursofOperations as $hours) {
                $hour = $hours->getAttributes();
                $dt1 = new Carbon($hour['open_time']);
                $dt2 = new Carbon($hour['close_time']);
                $dataVendorHour['day'] = $this->getDaysfromNumber($hour['days']);
                $dataVendorHour['open_time'] = $dt1->format('h:i A');
                $dataVendorHour['close_time'] = $dt2->format('h:i A');
                array_push($data['vendor_details']['hours_of_operations'], $dataVendorHour);
            }

            return $this->responseJson('success', \Config::get('constants.VENDOR_RATING_DETAILS'), 200, $data);
        } catch (\Exception $e) {
            //throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function getDaysfromNumber($number) {
        switch ($number) {
            case 1:
                return 'Monday';
                break;
            case 2:
                return 'Tuesday';
                break;
            case 3:
                return 'Wednesday';
                break;
            case 4:
                return 'Thursday';
                break;
            case 5:
                return 'Friday';
                break;
            case 6:
                return 'Saturday';
                break;
            case 7:
                return 'Sunday';
                break;
            default:
                return 'Invalid';
                break;
        }
    }

    //NearBy Vendors 
    public function getNearByVendors(Request $request) {
        try {
// get the request
            $data = $request->all();
//add lat long if passsed to the data
            $passdata = $data;
            $user_detail = \App\UserDetail::saveUserDetail($passdata, Auth::user()->id);
//find nearby vendors
            $vendorlist = VendorDetail::getNearestVendor($data);
            if (count($vendorlist) > 0) {
                $data = (new VendorTransformer())->transformList($vendorlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_LIST'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            //throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function getVendorDetails(Request $request) {
        try {
            $data = $request->all();
            $vendorDetails = VendorDetail::getVendorDetails($data['vendor_id']);
            $data['vendor_details'] = (new VendorTransformer())->transformvendorData($vendorDetails->getAttributes());
            $hoursofOperations = VendorHours::getHoursOfOperations($data['vendor_id']);
            $data['vendor_details']['hours_of_operations'] = [];
            foreach ($hoursofOperations as $hours) {
                $hour = $hours->getAttributes();
                $dt1 = new Carbon($hour['open_time']);
                $dt2 = new Carbon($hour['close_time']);
                $dataVendorHour['day'] = $this->getDaysfromNumber($hour['days']);
                $dataVendorHour['open_time'] = $dt1->format('h:i A');
                $dataVendorHour['close_time'] = $dt2->format('h:i A');
                array_push($data['vendor_details']['hours_of_operations'], $dataVendorHour);
            }
            return $this->responseJson('success', \Config::get('constants.VENDOR_RATING_DETAILS'), 200, $data);
        } catch (\Exception $e) {
            //throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

}
