<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Services\MailTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\Subscription;
use App\Stripewebhook;
use App\User;
use App\StripeUser;
use App\VendorDetail;
use App\Http\Controllers\Api\v1\Auth;
use Mail;

class StripeController extends Controller {

    use MailTrait;

    public function handleStripeResponse(Request $request) {

        $endpoint_secret = "whsec_hu613xZdLxCA3gjkLaFmrDawl3V4DZsq";

        $stripe_secret = \Config::get('constants.STRIPE_SECRET');
//        http_response_code(200);
        \Stripe\Stripe::setApiKey($stripe_secret);

        $input = @file_get_contents("php://input");

        $payload = $input;

        // You can find your endpoint's secret in your webhook settings

        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                            $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400); // PHP 5.4 or greater
            exit();
        } catch (\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            http_response_code(400); // PHP 5.4 or greater
            exit();
        }
        $user_id = $event->data->object->customer;
        $user_details = Stripewebhook::getUserDetails($user_id);
        if ($event->type == 'charge.failed') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'paymentfailed',
                'data' => ['confirmation_code' => 'Test'],
            ];
            $this->sendMail($array_mail);
        } elseif ($event->type == 'charge.succeeded') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'payment_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
            $this->sendMail($array_mail);
        } elseif ($event->type == 'customer.subscription.deleted') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'subscription_cancel_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
            $this->sendMail($array_mail);
        }
//        } elseif ($event->type == 'customer.subscription.updated') {
//            $type = 'subscription_upgrade_success';
//            $type = 'subscription_downgrade_success';
//            $array_mail = ['to' => $user_details->email,
//                'type' => $type,
//                'data' => ['confirmation_code' => 'Test'],
//            ];
//            $this->sendMail($array_mail);
//        }
        $data = array('user_id' => $user_details->user_id, 'stripe_id' => $user_details->stripe_id, 'type' => $event->type, 'status' => 0);
//        print_r($data);die;
        $test = Stripewebhook::createStripe($data);
        http_response_code(200);
    }

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
