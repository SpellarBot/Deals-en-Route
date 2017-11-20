<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Services\MailTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\Subscription;
use App\Stripewebhook;
use App\User;
use App\StripeUser;
use App\Http\Controllers\Frontend\Auth;
use Mail;

class StripeController extends Controller {

    use MailTrait;

    public function deleteCard() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $cardid = $stripedetails->card_id;
        $customer = \App\StripeUser::deleteCard($customerid, $cardid);
        if ($customer['deleted'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateCard() {
        $data = array('card_expiry' => '10/23', 'card_no' => '4242424242424242', 'card_cvv' => '123');
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $stripe_id = $stripedetails->id;
        $createcard = StripeUser::createCard($customerid, $data, $stripe_id);
        print_r($createcard);
        die;
    }

    public function changeSubscription() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $data = array('stripe_id' => $customerid, 'plan_id' => 'gold', 'user_id' => $stripedetails->user_id);
        $change = \App\StripeUser::changeSubscription($data);
    }

    public function updateSubscription() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $subscription = \App\Subscription::getSubscription($customerid, $userid);
        $data = array('stripe_id' => $customerid, 'plan_id' => 'silver', 'user_id' => $stripedetails->user_id, 'sub_id' => $subscription->sub_id);
        $change = \App\StripeUser::updateSubscription($data);
    }

    public function cancelSubscription() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $subscription = \App\Subscription::getSubscription($customerid, $userid);
        $data = array('subscription_id' => $subscription->sub_id, 'stripe_id' => $customerid);
        $cancelsubscription = \App\StripeUser::cancelSubscription($data);
    }

}
