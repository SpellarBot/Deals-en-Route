<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Stripe\Stripe;
use Laravel\Cashier\Billable;

class StripeUser extends Model {

    use Billable;

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

        $this->stripe = new Stripe(env('STRIPE_SECRET'), env('STRIPE_VERSION'));
    }

    /**
     * Get the user detail record associated with the customer id.
     */
    public function userStripe() {
        return $this->hasOne('App\User', 'id', 'user_id');
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

}
