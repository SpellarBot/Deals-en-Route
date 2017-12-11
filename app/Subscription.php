<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use App\Http\Services\StripeTrait;

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
        'created_at', 'updated_at', 'ends_at', 'trial_ends_at'
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
        $subcribe->trial_ends_at = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
        $subcribe->save();
        return true;
    }

    public function getRenewalCoupon($userAccess) {

        $renewEndDate = $this->calcMonthlyRenewal($this->created_at);
        $renewStartDate = Carbon::parse($renewEndDate)->subDays(30);
        //echo  $renewstartdate.$renewenddate;   exit;
        $totalCouponsUsed = $this->totalCouponForMonth($renewStartDate, $renewEndDate);

        if ($totalCouponsUsed || $totalCouponsUsed==0 ) {
 
            $totalCouponLeft = $userAccess->deals - $totalCouponsUsed;
            return $totalCouponLeft;
        }
        return 0;
    }

    public function totalCouponForMonth($startdate, $enddate) {

        $count = Coupon:: whereBetween('created_at', [$startdate->format('Y-m-d')." 00:00:00", $enddate->format('Y-m-d')." 23:59:59"])
                ->where('created_by', Auth::id())
                ->count();
        return $count;
    }

}
