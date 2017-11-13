<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stripetest extends Model {

    //
    public $table = 'stripetest';
    protected $fillable = [
        'data'
    ];

    public function createStripe($data) {
        $user = Stripetest::create([
                    'data' => $data
        ]);
        return $user;
    }

}
