<?php

namespace App\Http\Services;

use App\User;
use Auth;
use Carbon\Carbon;

trait StripeTrait {

    public function subscription($subscription = 'default', $plan) {
        return \App\Subscription::where('user_id', Auth::id())
                        ->where('name', $subscription)
                        ->where('stripe_plan', $plan)
                        ->first();
    }

    public function subscriptions() {
        return $this->hasMany(\App\Subscription::class, 'user_id')
                        ->orderBy('created_at', 'desc');
    }

    /**
     * Determine if the Stripe model is on a "generic" trial at the model level.
     *
     * @return bool
     */
    public function onGenericTrial() {

        return Carbon::parse($this->trial_ends_at) && Carbon::now()->lt(Carbon::parse($this->trial_ends_at));
    }

    /**
     * Determine if the Stripe model is on trial.
     *
     * @param  string  $subscription
     * @param  string|null  $plan
     * @return bool
     */
    public function onTrial($subscription = 'default', $plan = null) {
       
        $subscription = $this->subscription($subscription, $plan);

        if ($subscription) {
                  
            if (func_num_args() === 0 && $this->onGenericTrial()) {
            return true;
        }
            return $subscription->stripe_plan === $plan;
        }
        
        return false;
    }
    
    public function calcMonthlyRenewal($subscribedDate) {
    $now = Carbon::now('UTC');
    $months = $subscribedDate->diffInMonths($now);
    $renewsDate = $subscribedDate->copy()->addMonths($months);
    if($renewsDate->month > $now->month && $renewsDate->day != $subscribedDate->day) {
        $renewsDate = $renewsDate->subMonth()
            ->lastOfMonth()
            ->addHours($subscribedDate->hour)
            ->addMinutes($subscribedDate->minute)
            ->addSeconds($subscribedDate->second);
    }

    return $renewsDate;
}

}
