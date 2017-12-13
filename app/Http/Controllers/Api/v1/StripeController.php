<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Services\MailTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use App\Subscription;
use App\Stripewebhook;
use App\User;
use App\StripeUser;
use App\VendorDetail;
use App\PaymentInfo;
use App\Http\Controllers\Api\v1\Auth;
use Mail;
use App\Http\Services\PdfTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\ResponseTrait;

class StripeController extends Controller {

    use ResponseTrait;
    use MailTrait;
    use PdfTrait;

    protected function validatorplan(array $data) {
        return Validator::make($data, [
                    'plan' => 'in:bronze,silver,gold',
        ]);
    }

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
        $amount = $event->data->object->amount;
        $description = $event->data->object->description;
        $transaction_id = $event->data->object->id;
        $user_details = Stripewebhook::getUserDetails($user_id);
        $plan_details = Subscription::select('stripe_plan')->where('user_id', $user_details->user_id)->first();
        $plan_array = $plan_details->getAttributes();
        $plan = $plan_array['stripe_plan'];
        if ($event->type == 'charge.failed') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'paymentfailed',
                'data' => ['confirmation_code' => 'Test'],
            ];
            $this->sendMail($array_mail);
            if ($description != 'CommisionPayment') {
                $data = array();
                $data['vendor_id'] = $user_details->user_id;
                $data['totalamount'] = $amount / 100;
                $data['status'] = 'failed';
                $data['description'] = 'PaymentFailed';
                $details['payment_type'] = 'subscription';
                $data['transaction_id'] = $transaction_id;
                $data['invoice'] = '';
                PaymentInfo::create($data);
            }
        } elseif ($event->type == 'charge.succeeded') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'payment_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
            if ($description != 'CommisionPayment') {
                $data = array();
                $data['vendor_id'] = $user_details->user_id;
                $data['totalamount'] = $amount / 100;
                $data['status'] = 'success';
                $data['description'] = 'PaymentSuccessfull';
                $data['item_name'] = $plan;
                $data['item_type'] = 'subscription';
                $details['payment_type'] = 'subscription';
                $data['transaction_id'] = $transaction_id;
                $data['invoice'] = $this->invoice($data);
                \App\PaymentInfo::create($data);
                $array_mail['invoice'] = storage_path('app/pdf/' . $data['invoice']);
            }
            $this->sendMail($array_mail);
//        } elseif ($event->type == 'customer.subscription.deleted') {
//            $array_mail = ['to' => $user_details->email,
//                'type' => 'subscription_cancel_success',
//                'data' => ['confirmation_code' => 'Test'],
//            ];
//            $this->sendMail($array_mail);
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
                $this->checkPendingPayment();
                return $this->responseJson('success', 'Card Updated SuccessFully!!!', 200);
            } else {
                return $this->responseJson('error', $updatecard, 400);
            }
        } else {
            return $this->responseJson('error', $deletcard[0], 400);
        }
    }

    public function invoice($payment) {
        $details = array();
        $vendor_email = User::select('email')->find($payment['vendor_id']);
        $vendor_details = VendorDetail::select('country.country_name', 'billing_businessname', 'billing_home', 'billing_city', 'billing_country', 'billing_state', 'billing_zip')
                ->leftjoin('country', 'id', 'billing_country')
                ->where('user_id', $payment['vendor_id'])
                ->first();
        $details['items'] = array();
        $item = array('item_name' => $payment['item_name'], 'item_type' => $payment['item_type'], 'amount' => $payment['totalamount']);
        array_push($details['items'], $item);
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

    public function checkPendingPayment() {
        $user_id = Auth::id();
        $pendingPayment = PaymentInfo::getPendingPayments($user_id);
        if (count($pendingPayment) > 0) {
            foreach ($pendingPayment as $payment) {
                $pay = $payment->getAttributes();
                $vendor = StripeUser::getCustomerDetails($pay['vendor_id']);
                $user_details = \App\User::select('email')->find($pay['vendor_id']);
                $vendor_mail = $user_details->getAttributes();
                try {
                    $pay = StripeUser::chargeVendor($vendor, $pay['payment_amount'], 'PendingPayment');
                    $payment['transaction_id'] = $pay['id'];
                    $payment['vendor_id'] = $pay['vendor_id'];
                    $payment['totalamount'] = $pay['payment_amount'];
                    $payment['item_name'] = $pay['payment_type'];
                    $payment['item_type'] = $pay['payment_type'];
                    $invoice = $this->invoice($payment);
                    $array_mail = ['to' => $vendor_mail['email'],
                        'type' => 'payment_success',
                        'data' => ['confirmation_code' => 'Test'],
                        'invoice' => storage_path('app/pdf/' . $invoice)
                    ];
                    $this->sendMail($array_mail);
                    $payment->transaction_id = $pay['id'];
                    $payment->description = 'PaymentSuccessfull';
                    $payment->invoice = $invoice;
                    $payment->payment_status = 'success';
                    $payment->save();
                } catch (Cartalyst\Stripe\Exception\ServerErrorException $e) {
                    $array_mail = ['to' => $vendor_mail['email'],
                        'type' => 'paymentfailed',
                        'data' => ['confirmation_code' => 'Test']
                    ];
                    $this->sendMail($array_mail);
                    $payment->description = $e->getMessage();
                    $payment->payment_status = 'failed';
                    $payment->save();
                } catch (Cartalyst\Stripe\Exception\CardErrorException $e) {
                    $array_mail = ['to' => $vendor_mail['email'],
                        'type' => 'paymentfailed',
                        'data' => ['confirmation_code' => 'Test']
                    ];
                    $this->sendMail($array_mail);
                    $payment->description = $e->getMessage();
                    $payment->payment_status = 'failed';
                    $payment->save();
                }
            }
        }
    }

}
