<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\Stripetest;

class StripeController extends Controller {

    //
    public $endpoint_secret = "whsec_hu613xZdLxCA3gjkLaFmrDawl3V4DZsq";

    public function handleStripeResponse(Request $request) {

        \Stripe\Stripe::setApiKey('sk_test_ZBNhTnKmE3hEkk26awNMDdcc');

        $input = @file_get_contents("php://input");

        $payload = json_decode($input);

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

        if (isset($event) && $event->type == "invoice.payment_failed") {
            $customer = \Stripe\Customer::retrieve($event->data->object->customer);
            $email = $customer->email;
            // Sending your customers the amount in pennies is weird, so convert to dollars
            $amount = sprintf('$%0.2f', $event->data->object->amount_due / 100.0);
        }
        $data = array('custm' => $customer, 'email' => $email, 'amount' => $amount);
        $test = Stripetest::createStripe(json_encode($data));
        http_response_code(200);
    }

}
