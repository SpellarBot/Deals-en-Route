<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stripewebhook extends Model {

    //
    public $table = 'stripewebhook';
    protected $fillable = [
        'user_id', 'stripe_id', 'type', 'status'
    ];

    public static function createStripe($data) {
        $user = Stripewebhook::create([
                    'user_id' => $data['user_id'],
                    'stripe_id' => $data['stripe_id'],
                    'type' => $data['type'],
                    'status' => $data['status']
        ]);
        return $user;
    }

    public static function getUserDetails($stripe_id) {
        $users = DB::table('stripe_users')
                ->join('users', 'users.id', '=', 'stripe_users.user_id')
                ->where('stripe_users.stripe_id', $stripe_id)
                ->first();
        return $users;
    }

}
