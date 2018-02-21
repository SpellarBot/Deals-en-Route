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
use App\DealCommentLikes;
use App\CouponFavourite;

class CouponController extends Controller {

    use ResponseTrait;
    use PdfTrait;
    use Notifiable;
    use \App\Http\Services\CouponTrait;
    use \App\Http\Services\ActivityTrait;
    use \App\Http\Services\MailTrait;
    use \App\Http\Services\ImageTrait;

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
            $passdata = $data;
            unset($passdata['category_id']);
            $user_detail = \App\UserDetail::saveUserDetail($passdata, Auth::user()->id);
//find nearby coupon
            $couponlist = \App\Coupon::getNearestCoupon($data);
            if (count($couponlist) > 0) {
                foreach ($couponlist as $coupons) {
                    $getlikes = CouponFavourite::getLikes($coupons->coupon_id);
                    $getUserslike = CouponFavourite::getUserLike($coupons->coupon_id, auth()->id());
                    $getComments = DealComments::getComments($coupons->coupon_id);
                    $getvendorRating = VendorRating::getRatings($coupons->created_by);
                    $coupons->total_likes = ($getlikes == 0 ? 0 : $getlikes['total_likes']);
                    $coupons->total_comments = ($getComments == 0 ? 0 : $getComments['total_comments']);
                    $coupons->vendor_ratings = ($getvendorRating == 0 ? 0 : number_format(($getvendorRating['total_ratings'] / 5), 1));
                    $coupons->is_liked = ($getUserslike == 0 ? 0 : $getUserslike);
                }
                $data = (new CouponTransformer)->transformList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_LIST'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            //throw $e;
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
            return $this->responseJson('success', \Config::get('constants.NO_DEAL'), 200);
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
                foreach ($coupondetail as $coupons) {
                    $getlikes = CouponFavourite::getLikes($coupons->coupon_id);
                    $getUserslike = CouponFavourite::getUserLike($coupons->coupon_id, auth()->id());
                    $getComments = DealComments::getComments($coupons->coupon_id);
                    $getvendorRating = VendorRating::getRatings($coupons->created_by);
                    $coupons->total_likes = ($getlikes == 0 ? 0 : $getlikes['total_likes']);
                    $coupons->total_comments = ($getComments == 0 ? 0 : $getComments['total_comments']);
                    $coupons->vendor_ratings = ($getvendorRating == 0 ? 0 : number_format(($getvendorRating['total_ratings'] / 5), 1));
                    $coupons->is_liked = ($getUserslike == 0 ? 0 : $getUserslike);
                }
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
                foreach ($coupondetail as $coupons) {
                    $getlikes = CouponFavourite::getLikes($coupons->coupon_id);
                    $getUserslike = CouponFavourite::getUserLike($coupons->coupon_id, auth()->id());
                    $getComments = DealComments::getComments($coupons->coupon_id);
                    $getvendorRating = VendorRating::getRatings($coupons->created_by);
                    $coupons->total_likes = ($getlikes == 0 ? 0 : $getlikes['total_likes']);
                    $coupons->total_comments = ($getComments == 0 ? 0 : $getComments['total_comments']);
                    $coupons->vendor_ratings = ($getvendorRating == 0 ? 0 : number_format(($getvendorRating['total_ratings'] / 5), 1));
                    $coupons->is_liked = ($getUserslike == 0 ? 0 : $getUserslike);
                }
                $data = (new CouponTransformer)->transformFavSearchList($coupondetail);
                return $this->responseJson('success', \Config::get('constants.COUPON_LIST'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
// throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function redeemCouponList(Request $request) {
        try {
// get the request
            $data = $request->all();

            $couponlist = \App\CouponRedeem::redeemCouponList($data);

            if (count($couponlist) > 0) {
                foreach ($couponlist as $coupons) {
                    $getlikes = CouponFavourite::getLikes($coupons->coupon_id);
                    $getUserslike = CouponFavourite::getUserLike($coupons->coupon_id, auth()->id());
                    $getComments = DealComments::getComments($coupons->coupon_id);
                    $getvendorRating = VendorRating::getRatings($coupons->created_by);
                    $coupons->total_likes = ($getlikes == 0 ? 0 : $getlikes['total_likes']);
                    $coupons->total_comments = ($getComments == 0 ? 0 : $getComments['total_comments']);
                    $coupons->vendor_ratings = ($getvendorRating == 0 ? 0 : number_format(($getvendorRating['total_ratings'] / 5), 1));
                    $coupons->is_liked = ($getUserslike == 0 ? 0 : $getUserslike);
                }
                $data = (new CouponTransformer)->transformShareList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
////  throw $e;
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
                foreach ($couponlist as $coupons) {
                    $getlikes = CouponFavourite::getLikes($coupons->coupon_id);
                    $getUserslike = CouponFavourite::getUserLike($coupons->coupon_id, auth()->id());
                    $getComments = DealComments::getComments($coupons->coupon_id);
                    $getvendorRating = VendorRating::getRatings($coupons->created_by);
                    $coupons->total_likes = ($getlikes == 0 ? 0 : $getlikes['total_likes']);
                    $coupons->total_comments = ($getComments == 0 ? 0 : $getComments['total_comments']);
                    $coupons->vendor_ratings = ($getvendorRating == 0 ? 0 : number_format(($getvendorRating['total_ratings'] / 5), 1));
                    $coupons->is_liked = ($getUserslike == 0 ? 0 : $getUserslike);
                }
                $data = (new CouponTransformer)->transformShareList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
//  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function addRedeem(Request $request) {
        try {
// get the request
            $data = $request->all();

//find nearby coupon
            $redeem = new \App\CouponRedeem();
            $redeem->user_id = Auth::id();
            $redeem->coupon_id = $data['coupon_id'];
            $redeem->is_redeem = 1;

            if ($redeem->save()) {

                if ($this->getCouponShareCount('', $data['coupon_id']) > 0) {
                    $activity = \App\Activity::redeemActivity($data, Auth::id());
                }
                return $this->responseJson('success', \Config::get('constants.COUPON_ADD_REDEEM'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
//  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

//cron job for new coupon
    public function CouponNotificationNew(Request $request) {
        $newcouponuser = \App\User::where('role', 'user')
                ->leftJoin('user_detail', 'user_detail.user_id', '=', 'users.id')
                ->leftJoin('device_detail', 'device_detail.user_id', '=', 'users.id')
                ->where('latitude', '!=', '')
                ->where('longitude', '!=', '')
                ->where('device_token', '!=', '')
                ->where('notification_new_offer', 1)
                ->get();

        $circle_radius = \Config::get('constants.EARTH_RADIUS');

        foreach ($newcouponuser as $newcouponusers) {

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
            foreach ($couponlist as $couponlists) {
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

    public function getCoupons() {
        $coupon = \App\Coupon::couponList();
        if (count($coupon) > 0) {
            $coupon_data = array();
            foreach ($coupon as $c) {
                $coupons = $c->getAttributes();

                if ($coupons['category_image'] && !empty($coupons['category_image'])) {
                    $coupons['coupon_logo'] = URL::to('storage/app/public/coupon_logo/' . $coupons['category_image']);
                } else {
                    $coupons['coupon_logo'] = URL::to('storage/app/public/coupon_logo/');
                }
                array_push($coupon_data, $coupons);
            }
            $data = (new CouponTransformer)->transformListVendor((object) $coupon_data);
            return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
        } else {
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        }
    }

    public function addContact(Request $request) {
        try {
            $data = $request->all();
            $array_mail = ['to' => \Config::get('constants.CLIENT_MAIL'),
                'type' => 'contactuser',
                'data' => ['topic' => $request['topic'], 'question' => $request['question'],
                    'username' => Auth::user()->first_name . " " . Auth::user()->last_name]
            ];

            $mail = $this->sendMail($array_mail);
            return $this->responseJson('success', \Config::get('constants.CONTACT_SUCCESS'), 200);
        } catch (\Exception $e) {
//  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function CouponRedemption(Request $request) {
        $data = $request->all();
        $coupondata = explode('-', $data['coupon']);
        $data['coupon_code'] = $coupondata[1];
        $data['user_id'] = $coupondata[2];
        $getCoupondetails = \App\Coupon::getCouponDetailByCode($data);
        if (count($getCoupondetails) > 0) {
            if ($getCoupondetails->coupon_total_redeem == $getCoupondetails->coupon_redeem_limit) {
                $user = \App\User::find($data['user_id']);
// send notification success for coupon failure
                Notification::send($user, new FcmNotification([
                    'type' => 'redeemfailure',
                    'notification_message' => \Config::get('constants.NOTIFY_REDEEMPTION_FAILED'),
                    'message' => \Config::get('constants.NOTIFY_REDEEMPTION_FAILED'),
                    'image' => (!empty($getCoupondetails->coupon_logo)) ? URL::to('/storage/app/public/coupon_logo/tmp') . '/' . $getCoupondetails->coupon_logo : "",
                    'coupon_id' => $getCoupondetails->coupon_id
                ]));
                return $this->responseJson('error', 'Maximum Coupon Redeemption Limit Reached', 400);
            } else {
                $commision = $this->deductiveCommision($getCoupondetails);
                $user = \App\User::find($data['user_id']);
// send notification success for coupon redeem
                Notification::send($user, new FcmNotification([
                    'type' => 'redeemsuccess',
                    'notification_message' => \Config::get('constants.NOTIFY_REDEEMPTION'),
                    'message' => \Config::get('constants.NOTIFY_REDEEMPTION'),
                    'image' => (!empty($getCoupondetails->coupon_logo)) ? URL::to('/storage/app/public/coupon_logo/tmp') . '/' . $getCoupondetails->coupon_logo : "",
                    'coupon_id' => $getCoupondetails->coupon_id,
                    'is_reedem' => 1
                ]));

                if ($this->getCouponShareWebCount($getCoupondetails->coupon_id, $data['user_id']) > 0) {
                    $activity = \App\Activity::redeemActivity($getCoupondetails, $data['user_id']);
                }
                $couponReedem = array();
                $couponReedem['user_id'] = $data['user_id'];
                $couponReedem['coupon_id'] = $getCoupondetails['coupon_id'];
                \App\CouponRedeem::addCouponReedem($couponReedem);
                $getCoupondetails->coupon_total_redeem = $getCoupondetails->coupon_total_redeem + 1;
                $getCoupondetails->save();

                return $this->responseJson('success', 'Coupon Redeemed Successfully. ', 200);
            }
        } else {
            return $this->responseJson('failed', 'Invalid redemption code. ', 200);
        }
    }

    public function deductiveCommision($coupon) {
        if ($coupon['coupon_discounted_price'] && !empty($coupon['coupon_discounted_price'])) {
            $discount = number_format(($coupon['coupon_discounted_price'] * 30) / 100, 2);
            if ($discount < 1) {
                $amount = 1;
            } else {
                $amount = $discount;
            }
        } else {
            $coupon_discount_price = $coupon['coupon_original_price'] - $coupon['coupon_total_discount'];
            $discount = number_format(($coupon_discount_price * 30) / 100, 2);
            if ($discount < 1) {
                $amount = 1;
            } else {
                $amount = $discount;
            }
        }
        $vendor_id = Auth::id();
        $data = array();
        $data['vendor_id'] = $vendor_id;
        $data['amount'] = $amount;
        $data['coupon_id'] = $coupon['coupon_id'];
        $addcommision = Commision::create($data);
        if ($addcommision) {
            return true;
        } else {
            return false;
        }
    }

// Payout commission every month cron
    public function commisionPayout() {
        $payouts = Commision::getCommisionDetails();
        if (count($payouts) > 0) {
            foreach ($payouts as $pay) {
                $commisiondetails = $pay->getAttributes();
                $vendor = StripeUser::getCustomerDetails($commisiondetails['vendor_id']);
                $user_details = \App\User::select('email')->find($commisiondetails['vendor_id']);
                $vendor_mail = $user_details->getAttributes();
                try {
                    $pay = StripeUser::chargeVendor($vendor, $commisiondetails['totalamount'], 'CommisionPayment');
                    $commisiondetails['transaction_id'] = $pay['id'];
                    $invoice = $this->invoice($commisiondetails);
                    $commisiondetails['status'] = 'success';
                    $commisiondetails['description'] = 'PaymentSuccessfull';
                    $commisiondetails['invoice'] = $invoice;
                    $commisiondetails['payment_type'] = 'commision';
                    $array_mail = ['to' => $vendor_mail['email'],
                        'type' => 'payment_success',
                        'data' => ['confirmation_code' => 'Test'],
                        'invoice' => storage_path('app/pdf/' . $commisiondetails['invoice'])
                    ];
                    $this->sendMail($array_mail);
                    $this->addPaymentDetails($commisiondetails);
                } catch (Cartalyst\Stripe\Exception\ServerErrorException $e) {
                    $commisiondetails['status'] = 'failed';
                    $commisiondetails['description'] = $e->getMessage();
                    $commisiondetails['invoice'] = '';
                    $commisiondetails['payment_type'] = 'commision';
                    $array_mail = ['to' => $vendor_mail['email'],
                        'type' => 'paymentfailed',
                        'data' => ['confirmation_code' => 'Test']
                    ];
                    $this->sendMail($array_mail);
                    $this->addPaymentDetails($commisiondetails);
                } catch (Cartalyst\Stripe\Exception\CardErrorException $e) {
                    $commisiondetails['status'] = 'failed';
                    $commisiondetails['description'] = $e->getMessage();
                    $commisiondetails['invoice'] = '';
                    $commisiondetails['payment_type'] = 'commision';
                    $array_mail = ['to' => $vendor_mail['email'],
                        'type' => 'paymentfailed',
                        'data' => ['confirmation_code' => 'Test']
                    ];
                    $this->sendMail($array_mail);
                    $this->addPaymentDetails($commisiondetails);
                }
            }
        } else {
            return json_encode('No Commision to payout');
        }
    }

    public function addPaymentDetails($data) {
        if ($data['status'] == 'success') {
            Commision::updateCommision($data);
        }
        $info = PaymentInfo::create($data);
        return json_encode('Successfully Payout Commision');
    }

    public function invoice($payment) {
        $details = array();
        $vendor_email = User::select('email')->find($payment['vendor_id']);
        $vendor_details = VendorDetail::select('country.country_name', 'billing_businessname', 'billing_home', 'billing_city', 'billing_country', 'billing_state', 'billing_zip')
                ->leftjoin('country', 'id', 'billing_country')
                ->where('user_id', $payment['vendor_id'])
                ->first();
        $commisionentries = Commision::select('coupon.coupon_name  as item_name', 'commision.amount')
                ->where('vendor_id', $payment['vendor_id'])
                ->where('commision.is_paid', 0)
                ->leftjoin('coupon', 'coupon.coupon_id', 'commision.coupon_id')
                ->get();
        $details['items'] = array();
        foreach ($commisionentries as $entry) {
            $item = $entry->getAttributes();
            $item['item_type'] = 'Commision Deduction';
            array_push($details['items'], $item);
        }
        $vendor_mail = $vendor_email->getAttributes();
        $vendor = $vendor_details->getAttributes();
        $vendor['email'] = $vendor_mail['email'];
        $details['total_amount'] = $payment['totalamount'];
        $details['transaction_id'] = $payment['transaction_id'];
        $details['vendor'] = $vendor;
        $details['commision'] = TRUE;
        $invoice = $this->generateInvoice($details);
        return $invoice;
    }

    public function addlike(Request $request) {
        $data = $request->all();
        $likeDeal = DealLikes::addLike($data);
        $getlikes = DealLikes::getLikes($data['coupon_id']);
        $response['total_likes'] = $getlikes['total_likes'];
        if ($data['is_like'] == 1) {
            return $this->responseJson('success', 'Coupon Like Successfully. ', 200, $response);
        } else {
            return $this->responseJson('success', 'Coupon UnLike Successfully. ', 200, $response);
        }
    }

    public function addComment(Request $request) {
        DB::beginTransaction();
        try {

            $data = $request->all();
            $commentDeal = DealComments::addComment($data);

            // save the user
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        return $this->responseJson('success', \Config::get('constants.COMMENT_ADD'), 200);
    }

    public function addCommentLike(Request $request) {
        try {
            // get the request
            $data = $request->all();
            //add like
            $addDealCommentlike = DealCommentLikes::addCommentLike($data);
            if ($addDealCommentlike) {
                return $this->responseJson('success', \Config::get('constants.DEAL_COMMENT_LIKE_SUCCESS'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.APP_ERROR'), 400);
        } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function getCommentsofDeal(Request $request) {

        try {
            $data = $request->all();
            $validator = $this->validatordetail($data);
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }
            //find comments
            $coupondetail = \App\Coupon::getCouponDetail($data);
            if (count($coupondetail) > 0) {
                if ($data['limit']) {
                    $limit = $data['limit'];
                } else {
                    $limit = 5;
                }
                if ($data['page'] == 1) {
                    $offset = 0;
                } else {
                    $offset = (($data['page'] - 1) * $limit);
                }
                $data['current_page'] = $data['page'];
                $data['coupon_details'] = (new CouponTransformer)->transformDetail($coupondetail);
                $getComments = DealComments::getCommentsByCoupon($data['coupon_id'], $offset, $limit);
                if (count($getComments) < (int) $limit) {
                    $data['hasMorePages'] = false;
                } else {
                    $data['hasMorePages'] = true;
                }
                $data['comments_list'] = [];
                foreach ($getComments as $com) {
                    $dt = new Carbon($com->updated_at);
                    $getUser = \App\UserDetail::where('user_id', $com->comment_by)->first();

                    $comment_details['comment_id'] = $com->id;
                    $comment_details['user_id'] = $getUser->user_id;
                    $comment_details['comment_by'] = $getUser->first_name . ' ' . $getUser->last_name;
                    $comment_details['profile_pic'] = ($getUser->profile_pic ? asset('storage/app/public/profile_pic/' . $getUser->profile_pic) : asset('storage/app/public/profile_pic/'));
                    if ($com->liked_by === auth()->id() && $com->is_like === 1) {
                        $comment_details['is_liked'] = 1;
                    } else {
                        $comment_details['is_liked'] = 0;
                    }

                    $tagfriendarray = explode(",", $com->tag_user_id);
                    $tags = [];
                    if (!empty($com->tag_user_id)) {
                        foreach ($tagfriendarray as $key => $val) {

                            $detail = \App\UserDetail::where('user_id', $val)->first();

                            $tags[$key]['user_id'] = (int) $val;
                            $tags[$key]['full_name'] = '@' . $detail->first_name . " " . $detail->last_name;
                            $tags[$key]['profile_pic'] = (!empty($detail->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $detail->profile_pic : "";
                        }
                    }
                    $comment_details['comment'] = $com->comment_desc;
                    $comment_details['parent_id'] = $com->parent_id;
                    $comment_details['tag_user_id'] = $tags;
                    $comment_details['comment_time'] = $dt->diffForHumans();
                    $getReplyComments = DealComments::getCommentsByParentId($com->parent_id, $com->id);
//                     print_r($getReplyComments); 

                    foreach ($getReplyComments as $keyreply => $valreply) {
                        $tagreplyfriendarray = explode(",", $valreply['tag_user_id']);
                        $tagsreply = [];
                        foreach ($tagreplyfriendarray as $key1 => $val1) {
                            if (!empty($val1)) {
                                $detailreply = \App\UserDetail::where('user_id', $val1)->first();

                                $tagsreply[$key1]['user_id'] = (int) $val1;
                                $tagsreply[$key1]['full_name'] = '@' . $detailreply->first_name . " " . $detailreply->last_name;
                                $tagsreply[$key1]['profile_pic'] = (!empty($detailreply->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $detail->profile_pic : "";
                            }
                        }

                        $dt2 = new Carbon($valreply['updated_at']);
                        $getReplyComments[$keyreply]['comment_by'] = $valreply['first_name'] . ' ' . $valreply['last_name'];
                        $getReplyComments[$keyreply]['profile_pic'] = ($valreply['profile_pic'] ? asset('storage/app/public/profile_pic/' . $valreply['profile_pic']) : asset('storage/app/public/profile_pic/'));

                        $getReplyComments[$keyreply]['comment_time'] = $dt2->diffForHumans();
                        $getReplyComments[$keyreply]['comment'] = $valreply['comment_desc'];
                        $getReplyComments[$keyreply]['tag_user_id'] = $tagsreply;

                        $getReplyComments[$keyreply]['comment_id'] = $valreply['id'];
                        if ($valreply['is_like'] === 1) {
                            $getReplyComments[$keyreply]['is_liked'] = 1;
                        } else {
                            $getReplyComments[$keyreply]['is_liked'] = 0;
                        }
                        unset($getReplyComments[$keyreply]['comment_desc']);
                        unset($getReplyComments[$keyreply]['id']);
                        unset($getReplyComments[$keyreply]['coupon_id']);
                        unset($getReplyComments[$keyreply]['updated_at']);
                        unset($getReplyComments[$keyreply]['liked_by']);
                        unset($getReplyComments[$keyreply]['is_like']);
                        unset($getReplyComments[$keyreply]['first_name']);
                        unset($getReplyComments[$keyreply]['last_name']);
                    }

                    $comment_details['replycomments'] = $getReplyComments;
                    array_push($data['comments_list'], $comment_details);
                }
//                exit;
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_DEAL'), 200);
        } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function editComment(Request $request) {
        $data = $request->all();
        $editcommentDeal = DealComments::editComment($data);
        return $this->responseJson('success', 'Comment Edit Successfully. ', 200);
    }

    public function getDistance($lat, $long, $coupon_lat, $coupon_long) {

        return '6371 * 2 * ASIN(SQRT(POWER(SIN((' . $lat .
                ' - ABS(' . $coupon_lat . ')) * PI() / 180 / 2), 2) + COS(' . $lat .
                ' * PI() / 180) * COS(ABS(' . $coupon_lat . ') * PI() / 180) * POWER(SIN((' . $long .
                ' - ' . $coupon_long . ') * PI() / 180 / 2), 2)))';
    }

    public function getVendorDetails(Request $request) {
        $data = $request->all();

        $vendor = \App\Coupon::getVendorDetails($data);
        $vendor['vendor_logo'] = ($vendor['vendor_logo'] ? asset('storage/app/public/vendor_logo/' . $vendor['vendor_logo']) : asset('storage/app/public/vendor_logo/'));
        if ($vendor) {
            return $this->responseJson('success', 'Vendor Details. ', 200, $vendor);
        } else {
            return $this->responseJson('error', 'Vendor not found!!  ', 400, $vendor);
        }
    }

    public function getCouponsByVendor(Request $request) {
        try {
// get the request
            $data = $request->all();
            $couponlist = \App\Coupon::getCouponByVendor($data['vendor_id']);
            if (count($couponlist) > 0) {
                foreach ($couponlist as $coupons) {
                    $getlikes = CouponFavourite::getLikes($coupons->coupon_id);
                    $getUserslike = CouponFavourite::getUserLike($coupons->coupon_id, auth()->id());
                    $getComments = DealComments::getComments($coupons->coupon_id);
                    $getvendorRating = VendorRating::getRatings($coupons->created_by);
                    $coupons->total_likes = ($getlikes == 0 ? 0 : $getlikes['total_likes']);
                    $coupons->total_comments = ($getComments == 0 ? 0 : $getComments['total_comments']);
                    $coupons->vendor_ratings = ($getvendorRating == 0 ? 0 : number_format(($getvendorRating['total_ratings'] / 5), 1));
                    $coupons->is_liked = ($getUserslike == 0 ? 0 : $getUserslike);
                }
                $data = (new CouponTransformer)->transformList($couponlist);
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            } else {
                return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
            }
        } catch (\Exception $e) {
//  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function deleteComment(Request $request) {
        $id = $request->id;
        $editcommentDeal = DealComments::deleteDealComment($id);
        return $this->responseJson('success', 'Comment deleted Successfully. ', 200);
    }

}
