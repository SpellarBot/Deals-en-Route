<?php

namespace App\Http\Controllers\Frontend;

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
use Mail;
use App\Http\Services\PdfTrait;
use Illuminate\Support\Facades\Storage;
use Auth;

class StripeController extends Controller {

    use MailTrait;
    use PdfTrait;

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
        if (isset($data['status']) && strtolower($data['status']) == 'upgrade') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'subscription_upgrade_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
            $this->sendMail($array_mail);
        } elseif (isset($data['status']) && strtolower($data['status']) == 'downgrade') {
            $array_mail = ['to' => $user_details->email,
                'type' => 'subscription_downgrade_success',
                'data' => ['confirmation_code' => 'Test'],
            ];
            $this->sendMail($array_mail);
        }

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
                $this->checkPendingPayment();
                return response()->json(['status' => 1, 'message' => 'Card Updated SuccessFully!!!'], 200);
            } else {
                return response()->json(['status' => 0, 'message' => $updatecard], 400);
            }
        } else {
            return response()->json(['status' => 0, 'message' => $deletcard[0]], 400);
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
                    $paym = StripeUser::chargeVendor($vendor, $pay['payment_amount'], 'PendingPayment');
                    $payment['transaction_id'] = $paym['id'];
                    $payment['vendor_id'] = $paym['vendor_id'];
                    $payment['totalamount'] = $paym['payment_amount'];
                    $payment['item_name'] = $paym['payment_type'];
                    $payment['item_type'] = $paym['payment_type'];
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
