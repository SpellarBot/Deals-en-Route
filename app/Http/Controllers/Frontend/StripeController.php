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
        $userid = auth()->id();
        $user_details = User::find($userid);
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $cancelcurrentsub = $this->cancelSubscription($data['plan']);
        if ($cancelcurrentsub == 0) {
            return response()->json(['status' => 0, 'message' => 'Please select Different Plan'], 400);
        }
        $details = array('stripe_id' => $customerid, 'plan_id' => $data['plan'], 'user_id' => $stripedetails->user_id);
        $change = \App\StripeUser::changeSubscription($details);
        $array_mail = array();
        if (isset($data['status']) && strtolower($data['status']) == 'upgrade') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'subscription_upgrade_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
        } elseif (isset($data['status']) && strtolower($data['status']) == 'downgrade') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'subscription_downgrade_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
        }
        $this->sendMail($array_mail);
        return response()->json(['status' => 1, 'message' => 'Subscription Updated SuccessFully!!!'], 200);
    }

    public function updateSubscription() {
        $userid = auth()->id();
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $subscription = \App\Subscription::getSubscription($customerid, $userid);
        $data = array('stripe_id' => $customerid, 'plan_id' => 'silver', 'user_id' => $stripedetails->user_id, 'sub_id' => $subscription->sub_id);
        $change = \App\StripeUser::updateSubscription($data);
    }

    public function cancelSubscription($plan = '') {
        $userid = auth()->id();
        $user_details = User::find($userid);
        $stripedetails = \App\StripeUser::getCustomerDetails($userid);
        $customerid = $stripedetails->stripe_id;
        $subscription = \App\Subscription::getSubscription($customerid, $userid);
        if ($subscription->stripe_plan == $plan && $subscription->sub_id != '') {
            return 0;
        } else if ($subscription->sub_id == '') {
            return 1;
        } else {
            $data = array('subscription_id' => $subscription->sub_id, 'stripe_id' => $customerid, 'user_id' => $subscription->user_id);
            $cancelsubscription = \App\StripeUser::cancelSubscription($data);
            if ($plan) {
                return 1;
            } else {
                $array_mail = ['to' => $user_details->email,
                    'type' => 'subscription_cancel_success',
                    'data' => ['confirmation_code' => 'Test'],
                ];
                $this->sendMail($array_mail);
                return redirect('/dashboard#settings');
//                return response()->json(['status' => 1, 'message' => 'Subscription Canceled SuccessFully!!!'], 200);
            }
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
