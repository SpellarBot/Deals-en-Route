<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use App\Http\Services\StripeTrait;
use Cartalyst\Stripe\Stripe;

class Subscription extends Model {

    protected $table = 'subscriptions';
    public $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    use StripeTrait;

    /**
     * Get the vendor detail record associated with the user.
     */
    public function planAccess() {
        return $this->hasOne('App\PlanAccess', 'plan_id', 'plan_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'stripe_id', 'user_id', 'name', 'quantity', 'stripe_plan',
        'created_at', 'updated_at', 'ends_at', 'trial_ends_at', 'startdate', 'enddate'
    ];

    public function __construct() {
        
    }

    public static function saveSubcriptionPlan($subcription, $userid) {
        $subcribe = new Subscription();
        $subcribe->user_id = $userid;
        $subcribe->stripe_id = $subcription['customer'];
        $subcribe->sub_id = $subcription['id'];
        $subcribe->stripe_plan = $subcription['plan']['id'];
        $subcribe->name = $subcription['plan']['name'];
        $subcribe->quantity = $subcription['quantity'];
        $subcribe->trial_ends_at = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
        $subcribe->save();
        $subdate = Subscription::getSubscriptiondates($subcription['customer']);
        $subcribe->startdate = $subdate['startdate'];
        $subcribe->enddate = $subdate['enddate'];
        $subcribe->save();
        return true;
    }

    public static function getSubscription($stripe_id, $user_id) {
        $subscription = Subscription::select('*')
                ->where('stripe_id', $stripe_id)
                ->where('user_id', $user_id)
                ->first();
        return $subscription;
    }

    public static function updateSubcriptionPlan($subcription, $userid) {
        $subcribe = Subscription::where('user_id', $userid)
                ->first();
        $subcribe->user_id = $userid;
        $subcribe->stripe_id = $subcription['customer'];
        $subcribe->sub_id = $subcription['id'];
        $subcribe->stripe_plan = $subcription['plan']['id'];
        $subcribe->name = $subcription['plan']['name'];
        $subcribe->quantity = $subcription['quantity'];
       $subcribe->trial_ends_at = Carbon::now()->format('Y-m-d H:i:s');
        $subcribe->save();
        $subdate = Subscription::getSubscriptiondates($subcription['customer']);
        $subcribe->startdate = $subdate['startdate'];
        $subcribe->enddate = $subdate['enddate'];
        $subcribe->save();
        return true;
    }

    public function getRenewalCoupon($userAccess) {


        //echo  $renewstartdate.$renewenddate;   exit;
        $totalCouponsUsed = $this->totalCouponForMonth();

        if ($totalCouponsUsed || $totalCouponsUsed == 0) {

            $totalCouponLeft = $userAccess['dealstotal'] - $totalCouponsUsed;
            $vendordetail= \App\VendorDetail::where('user_id', Auth::id())->update(['deal_used' => $totalCouponsUsed]);
            return $totalCouponLeft;
        }
     
        return 0;
    }

//    public function totalCouponForMonth() {
//
//        $stripe = new Stripe(\Config::get('constants.STRIPE_SECRET'), \Config::get('constants.STRIPE_VERSION'));
//        $subscriptionmodel = Subscription::where('stripe_id', $this->stripe_id)->first();
//
//        $subscription = $stripe->subscriptions()->find($this->stripe_id, $subscriptionmodel->sub_id);
//        if (!empty($subscription)) {
//            $startdate = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateString();
//            $enddate = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateString();
//
//            $count = Coupon:: whereBetween('created_at', [$startdate, $enddate])
//                    ->where('created_by', Auth::id())
//                    ->count();
//            return $count;
//        }
//    }
    public function totalCouponForMonth() {
        $subscriptionmodel = Subscription::where('stripe_id', $this->stripe_id)
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('sub_id','!=','')
                ->first();

        if (count($subscriptionmodel) > 0) {
            $startdate = $subscriptionmodel->startdate;
            $enddate = $subscriptionmodel->enddate;
            $count = Coupon:: whereBetween('created_at', [$startdate, $enddate])
                    ->where('created_by', Auth::id())
                    ->count();
            return $count;
        }
        return 0;
    }

    public static function getSubscriptiondates($stripe_id) {
        $stripe = new Stripe(\Config::get('constants.STRIPE_SECRET'), \Config::get('constants.STRIPE_VERSION'));
        $subscriptionmodel = Subscription::where('stripe_id', $stripe_id)->first();
        $dates = array();
        $subscription = $stripe->subscriptions()->find($stripe_id, $subscriptionmodel->sub_id);
        if (!empty($subscription)) {
            $startdate = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateString();
            $enddate = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateString();
            $dates['startdate'] = $startdate;
            $dates['enddate'] = $enddate;
            return $dates;
        }
    }

}
