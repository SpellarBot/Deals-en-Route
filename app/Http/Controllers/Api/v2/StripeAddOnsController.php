<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Services\MailTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\Subscription;
use App\Stripewebhook;
use App\PlanAddOns;
use App\User;
use App\StripeUser;
use App\VendorDetail;
use App\Http\Controllers\Frontend\Auth;
use Mail;
use App\Http\Services\PdfTrait;
use App\Http\Services\ResponseTrait;

class StripeAddOnsController extends Controller {

    use MailTrait;
    use PdfTrait;
    use ResponseTrait;

    public function purchaseMiles(Request $request) {
        $data = $request->all();
        $user_id = auth()->id();
        if ($data['extra_miles'] == '') {
            return $this->responseJson('error', 'Please Select Value', 400);
        }
        $amount = 4.99 * $data['extra_miles'];
        $miles = $data['extra_miles'];
        $details = array('vendor_id' => $user_id, 'amount' => $amount, 'item_name' => $miles . ' Miles');
        $this->makePayment($details);
        $user = Subscription::where('user_id', $user_id)->first();
        $user_details = $user->getAttributes();
        $adoninsert = array('user_id' => $user_id,
            'plan_id' => $user_details['stripe_plan'],
            'addon_type' => 'geolocation',
            'quantity' => $miles,
            'startdate' => $user_details['startdate'],
            'enddate' => $user_details['enddate']);
        $add_ons = PlanAddOns::addOnsInsert($adoninsert);
        if ($add_ons) {
            return $this->responseJson('success', 'Extra Geo-Location(Miles) Added to your Plan.Thank You', 200);
        } else {
            return $this->responseJson('error', 'Please Try again Later', 400);
        }
    }

    public function purchaseGeoFence(Request $request) {
        $data = $request->all();
        $user_id = auth()->id();
        if ($data['extra_fensing_area'] == '') {
            return $this->responseJson('error', 'Please Select Value', 400);
        }
        $amount = 4.99 * ($data['extra_fensing_area'] / 20000);
        $fensingarea = $data['extra_fensing_area'];
        $details = array('vendor_id' => $user_id, 'amount' => $amount, 'item_name' => $data['extra_fensing_area'] . ' Geo Fensing Area');
        $this->makePayment($details);
        $user = Subscription::where('user_id', $user_id)->first();
        $user_details = $user->getAttributes();
        $adoninsert = array('user_id' => $user_id,
            'plan_id' => $user_details['stripe_plan'],
            'addon_type' => 'geofencing',
            'quantity' => $fensingarea,
            'startdate' => $user_details['startdate'],
            'enddate' => $user_details['enddate']);
        $add_ons = PlanAddOns::addOnsInsert($adoninsert);
        if ($add_ons) {
            return $this->responseJson('success', 'Extra Geo Fensing Area Added to your Plan.Thank You', 200);
        } else {
            return $this->responseJson('error', 'Please Try again Later', 400);
        }
    }

    public function purchaseDeals(Request $request) {
        $data = $request->all();
        $user_id = auth()->id();
        if ($data['extra_deals'] == '') {
            return $this->responseJson('error', 'Please Select Value', 400);
        }
        $amount = 4.99 * $data['extra_deals'];
        $deals = $data['extra_deals'];
        $details = array('vendor_id' => $user_id, 'amount' => $amount, 'item_name' => $deals . ' Deals');
        $this->makePayment($details);
        $user = Subscription::where('user_id', $user_id)->first();
        $user_details = $user->getAttributes();
        $adoninsert = array('user_id' => $user_id,
            'plan_id' => $user_details['stripe_plan'],
            'addon_type' => 'deals',
            'quantity' => $deals,
            'startdate' => $user_details['startdate'],
            'enddate' => $user_details['enddate']);
        $add_ons = PlanAddOns::addOnsInsert($adoninsert);
        if ($add_ons) {
            return $this->responseJson('success', 'Extra Deals Added to your Plan.Thank You', 200);
        } else {
            return $this->responseJson('error', 'Please Try again Later', 400);
        }
    }

    public function makePayment($data) {
        $vendor = StripeUser::getCustomerDetails($data['vendor_id']);
        $user_details = \App\User::select('email')->find($data['vendor_id']);
        $vendor_mail = $user_details->getAttributes();
        try {
            $pay = StripeUser::chargeVendor($vendor, $data['amount'], 'Ad-ons');
            $payment['vendor_id'] = $data['vendor_id'];
            $payment['transaction_id'] = $pay['id'];
            $payment['description'] = 'PaymentSuccessfull';
            $payment['totalamount'] = $data['amount'];
            $payment['payment_type'] = 'ad-ons';
            $payment['item_name'] = $data['item_name'];
            $payment['item_type'] = 'ad-ons';
            $invoice = $this->invoice($payment);
            $payment['invoice'] = $invoice;
            $array_mail = ['to' => $vendor_mail['email'],
                'type' => 'payment_success',
                'data' => ['confirmation_code' => 'Test'],
                'invoice' => storage_path('app/pdf/' . $payment['invoice'])
            ];
            $this->sendMail($array_mail);
            \App\PaymentInfo::create($payment);
        } catch (Cartalyst\Stripe\Exception\ServerErrorException $e) {
            $payment['description'] = $e->getMessage();
            $payment['invoice'] = '';
            $payment['payment_type'] = 'ad-ons';
            $array_mail = ['to' => $vendor_mail['email'],
                'type' => 'paymentfailed',
                'data' => ['confirmation_code' => 'Test']
            ];
            $this->sendMail($array_mail);
            \App\PaymentInfo::create($payment);
            return $this->responseJson('error', 'Payment Failed Please Try again Later', 400);
        } catch (Cartalyst\Stripe\Exception\CardErrorException $e) {
            $payment['description'] = $e->getMessage();
            $payment['invoice'] = '';
            $payment['payment_type'] = 'ad-ons';
            $array_mail = ['to' => $vendor_mail['email'],
                'type' => 'paymentfailed',
                'data' => ['confirmation_code' => 'Test']
            ];
            $this->sendMail($array_mail);
            \App\PaymentInfo::create($payment);
            return $this->responseJson('error', 'Payment Failed Please Try again Later', 400);
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

}
