<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Services\MailTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\Stripewebhook;
use Mail;

class StripeController extends Controller {

    use MailTrait;

    public function handleStripeResponse(Request $request) {

        $endpoint_secret = "whsec_hu613xZdLxCA3gjkLaFmrDawl3V4DZsq";

//        http_response_code(200);
        \Stripe\Stripe::setApiKey('sk_test_ZBNhTnKmE3hEkk26awNMDdcc');

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
        }
        $data = array('user_id' => $user_details->user_id, 'stripe_id' => $user_details->stripe_id, 'type' => $event->type, 'status' => 0);
//        print_r($data);die;
        $test = Stripewebhook::createStripe($data);
        http_response_code(200);
    }

}
