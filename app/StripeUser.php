<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Stripe\Stripe;

class StripeUser extends Model {

    protected $table = 'stripe_users';
    public $stripe;
    public $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'stripe_id', 'user_id', 'card_brand', 'card_last_four', 'trial_ends_at',
        'created_at', 'updated_at'
    ];

    public function __construct() {


        $this->stripe = new Stripe(\Config::get('constants.STRIPE_SECRET'), \Config::get('constants.STRIPE_VERSION'));
    }

    /**
     * Get the user detail record associated with the customer id.
     */
    public function userStripe() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function userSubscription() {
        return $this->hasOne('App\Subscription', 'user_id', 'user_id');
    }

    public static function createStripeUser($id) {

        $stripeuser = new \App\StripeUser();
        $stripeuser->user_id = $id;
        $stripeuser->save();
        return $stripeuser;
    }

    public function createToken($data) {
        $dateexplode = explode('/', $data['card_expiry']);
        $token = $this->stripe->tokens()->create([
            'card' => [
                'number' => $data['card_no'],
                'exp_month' => $dateexplode[0],
                'cvc' => $data['card_cvv'],
                'exp_year' => $dateexplode[1],
            ],
        ]);
        $customerid = $this->createCustomer($data);
        if ($customerid) {
            $this->storeCard($customerid, $token, $data);
        }
    }

    public static function getCustomerDetails($id) {
        $customer = StripeUser::select('*')
                ->where('user_id', $id)
                ->first();
        return $customer;
    }

//create customer
    public function createCustomer($data) {

        $customer = $this->stripe->customers()->create([
            'email' => $data['email'],
        ]);
        if (!empty($customer)) {
            $customerid = $customer['id'];
            return $customerid;
        }
        return false;
    }

// store the card of particular customer
    public function storeCard($customerid, $token, $data) {

        $card = $this->stripe->cards()->create($customerid, $token['id']);
        $this->stripe_id = $card['customer'];
        $this->card_id = $card['id'];
        $this->card_brand = $card['brand'];
        $this->card_last_four = $card['last4'];
        $this->save();
    }

//create subcription
    public function createSubcription($plan_id) {

        $stripeid = $this->stripe_id;
        $subscription = $this->stripe->subscriptions()->create($stripeid, ['plan' => $plan_id]);
        $result = Subscription::saveSubcriptionPlan($subscription, $this->user_id);
        if ($result) {
            return true;
        }
        return false;
    }

    public static function findCustomer($email) {
        $stripe = new StripeUser();
        $customers = $stripe->stripe->customers()->all(['limit' => 15]);

        foreach ($customers['data'] as $customer) {
            if ($customer['email'] == $email) {
                self::deleteCustomer($customer['id']);
            }
        }
    }

//delete a customer with existing id
    public static function deleteCustomer($customerid) {
        $stripe = new StripeUser();
        $customer = $stripe->stripe->customers()->delete($customerid);
    }

//Delete Current Card for existing stripe customer
    public static function deleteCard($customerid, $card_id) {
        $stripe = new StripeUser();
        $card = $stripe->stripe->cards()->delete($customerid, $card_id);
        return $card;
    }

//Create New Card and update details to database
    public static function createCard($customerid, $data, $stripe_id) {
        $stripe = New StripeUser();
        $dateexplode = explode('/', $data['card_expiry']);
        $token = $stripe->stripe->tokens($customerid)->create([
            'card' => [
                'number' => $data['card_no'],
                'exp_month' => $dateexplode[0],
                'cvc' => $data['card_cvv'],
                'exp_year' => $dateexplode[1],
            ],
        ]);
        if ($token && array_key_exists('id', $token)) {
            $card = $stripe->updateCard($customerid, $token, $stripe_id);
            return $card;
        } else {
            return $token;
        }
    }

// store the card of particular customer
    public function updateCard($customerid, $token, $stripe_id) {

        $card = $this->stripe->cards()->create($customerid, $token['id']);
        $data = array('card_id' => $card['id'], 'card_brand' => $card['brand'], 'card_last_four' => $card['last4']);
        $addCard = StripeUser::where('stripe_id', $customerid)->first();
        $addCard->card_id = $card['id'];
        $addCard->card_brand = $card['brand'];
        $addCard->card_last_four = $card['last4'];
        $addCard->save();
        return $card;
    }

    public static function cancelSubscription($data) {
        $stripe = New StripeUser();
        $subscription = $stripe->stripe->subscriptions()->cancel($data['stripe_id'], $data['subscription_id']);
        if ($subscription['status'] == 'canceled') {
            $subupdate = \App\Subscription::select('*')
                    ->where('user_id', $data['user_id'])
                    ->first();
            $subupdate->sub_id = '';
            $subupdate->save();
            return 1;
        }
        return 1;
    }

    public static function updateSubscription($data) {
        $stripe = New StripeUser();
        $subscription = $stripe->stripe->subscriptions()->update($data['stripe_id'], $data['sub_id'], [
            'plan' => $data['plan_id'], 'trial_end' => 'now',
        ]);
        \App\Subscription::updateSubcriptionPlan($subscription, $data['user_id']);

        return TRUE;
    }

    public static function changeSubscription($data) {
        $stripe = New StripeUser();
        $subscription = $stripe->stripe->subscriptions()->create($data['stripe_id'], [
            'plan' => $data['plan_id'], 'trial_end' => 'now',
        ]);
        \App\Subscription::updateSubcriptionPlan($subscription, $data['user_id']);
        return TRUE;
    }

    public static function chargeVendor($vendor, $amount, $description = '') {
        $stripe = New StripeUser();
        $charge = $stripe->stripe->charges()->create([
            'customer' => $vendor['stripe_id'],
            'currency' => 'USD',
            'amount' => $amount,
            'description' => $description
        ]);

        return $charge;
    }

}
