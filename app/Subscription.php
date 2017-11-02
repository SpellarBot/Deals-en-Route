<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {

    protected $table = 'subscriptions';
    public $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'stripe_id', 'user_id', 'name', 'quantity', 'stripe_plan',
        'created_at', 'updated_at', 'ends_at', 'trial_ends_at'
    ];

    public static function saveSubcriptionPlan($subcription, $userid) {
        $subcribe = new Subscription();
        $subcribe->user_id = $userid;
        $subcribe->stripe_id = $subcription['customer'];
        $subcribe->stripe_plan = $subcription['plan']['id'];
        $subcribe->name = $subcription['plan']['name'];
        $subcribe->quantity = $subcription['quantity'];
        $subcribe->trial_ends_at = $subcription['trial_end'];
        $subcribe->save();
        return true;
    }

}
