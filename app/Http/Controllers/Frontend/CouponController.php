<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Services\ImageTrait;
use App\Commision;
use App\PaymentInfo;
use App\Notifications\FcmNotification;
use App\Notifications;
use Notification;
use App\Coupon;
use Auth;
use DB;
use URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Session;

class CouponController extends Controller {

    use ImageTrait;
    use Notifiable;
    use \App\Http\Services\CouponTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth.vendor');
    }

    protected function validatordetail(array $data) {
        return Validator::make($data, [
                    'coupon' => 'required',
        ]);
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
        if ($coupon->save()) {
            return response()->json(['status' => 1, 'message' => ucwords(\Config::get('constants.COUPON_DELETE'))], 200);
        }
        return response()->json(['status' => 0, 'message' => ucwords(\Config::get('constants.APP_ERROR'))], 422);
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

            if (!empty($request['validationcheck']) && $request['validationcheck'] == 1) {

                $coupon = Coupon::addCoupon($request);
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
            return response()->json(['status' => 0, 'message' => \Config::get('constants.APP_ERROR')], 400);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        if (isset($coupon) && $coupon == true) {
            return response()->json(['status' => 1, 'message' => \Config::get('constants.COUPON_CREATE')], 200);
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $id = base64_decode($id);
        $coupon_lists = \App\Coupon::couponList();
        $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->where('vendor_detail.user_id', Auth::id())
                ->first();
        $user_access = $vendor_detail->userSubscription;

        $coupon = Coupon::where('coupon_id', $id)->first();
        $start_date = $coupon->convertDateInUserTZ($coupon->coupon_start_date);
        $end_date = $coupon->convertDateInUserTZ($coupon->coupon_end_date);
        return view('frontend.coupon.edit')->with(['coupon' => $coupon,
                    'coupon_lists' => $coupon_lists, 'vendor_detail' => $vendor_detail,
                    'start_date_converted' => $start_date, 'end_date_converted' => $end_date,
                    'user_access' => $user_access[0]]);
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
            if (!empty($request['validationcheck']) && $request['validationcheck'] == 1) {
                $id = $data['coupon_id'];

                $coupon = Coupon::updateCoupon($data, $id);
                $file = Input::file('coupon_logo');
                //store image
                if (!empty($file)) {
                    $this->addImageWeb($file, $coupon, 'coupon_logo');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            //  throw $e;
            return response()->json(['status' => 0, 'message' => \Config::get('constants.APP_ERROR')], 400);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        if (isset($coupon) && $coupon == true) {
            return response()->json(['status' => 1, 'message' => \Config::get('constants.COUPON_UPDATE')], 200);
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

    public function CouponRedemption(Request $request) {
        try {

            // get the request
            $data = $request->all();
            $validator = $this->validatordetail($data);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
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
                        'coupon_id' => $getCoupondetails->coupon_id,
                    ]));
                    return response()->json(['status' => 0, 'message' => 'Maximum Coupon Redeemption Limit Reached'], 200);
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
                    return response()->json(['status' => 1, 'message' => 'Coupon Redeemed Successfully.'], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'No Coupon Found.'], 200);
            }
        } catch (\Exception $e) {
            //  throw $e;
            return response()->json(['status' => 0, 'message' => \Config::get('constants.APP_ERROR')], 200);
        }
    }

}
