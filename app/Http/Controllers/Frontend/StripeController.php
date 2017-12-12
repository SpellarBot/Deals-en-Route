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
use App\VendorDetail;
use App\Http\Controllers\Frontend\Auth;
use Mail;

class StripeController extends Controller {

    use MailTrait;

    public function deleteCard() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $cardid = $stripedetails->card_id;
        try {
            $customer = \App\StripeUser::deleteCard($customerid, $cardid);
            if ($customer['deleted'] == 1) {
                return 1;
            } else {
                return 0;
            }
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return explode(':', $e->getMessage());
        }
    }

    public function updateCard($details) {
        $data = array('card_expiry' => $details['card_expiry'], 'card_no' => $details['card_no'], 'card_cvv' => $details['card_cvv']);
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $stripe_id = $stripedetails->id;
        try {
            $createcard = StripeUser::createCard($customerid, $data, $stripe_id);
            return $createcard;
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return $e->getMessage();
        }
    }

    public function changeSubscription(Request $request) {
        $data = $request->all();
        $validator = $this->validatorplan($data);
        if ($validator->fails()) {
            return $this->responseJson('error', $validator->errors()->first(), 400);
        }
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $cancelcurrentsub = $this->cancelSubscription($data['plan']);
        if ($cancelcurrentsub == 0) {
            return $this->responseJson('error', 'Please select Different Plan', 400);
        }
        $data = array('stripe_id' => $customerid, 'plan_id' => $data['plan'], 'user_id' => $stripedetails->user_id);
        $change = \App\StripeUser::changeSubscription($data);
        return $this->responseJson('success', 'Subscription Updated SuccessFully!!!', 200);
    }

    public function updateSubscription() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $subscription = \App\Subscription::getSubscription($customerid, $userid);
        $data = array('stripe_id' => $customerid, 'plan_id' => 'silver', 'user_id' => $stripedetails->user_id, 'sub_id' => $subscription->sub_id);
        $change = \App\StripeUser::updateSubscription($data);
    }

    public function cancelSubscription($plan) {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $subscription = \App\Subscription::getSubscription($customerid, $userid);
        if ($subscription->stripe_plan == $plan) {
            return 0;
        } else if ($subscription->sub_id == '') {
            return 1;
        } else {
            $data = array('subscription_id' => $subscription->sub_id, 'stripe_id' => $customerid, 'user_id' => $subscription->user_id);
            $cancelsubscription = \App\StripeUser::cancelSubscription($data);
            return 1;
        }
    }

    public function editCreditCard(Request $request) {
        $data = $request->all();
        $deletcard = $this->deleteCard();
        if ($deletcard == 1 || $deletcard[0] == 'No such source') {
            $updatecard = $this->updateCard($data);
            if (is_array($updatecard) && $updatecard) {
                return response()->json(['status' => 1, 'message' => 'Card Updated SuccessFully!!!'], 200);
            } else {
                return response()->json(['status' => 0, 'message' => $updatecard], 400);
            }
        } else {
            return response()->json(['status' => 0, 'message' => $deletcard[0]], 400);
        }
    }

}
