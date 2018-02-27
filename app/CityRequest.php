<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CityRequest extends Model {

    protected $table = 'city_request';
    protected $dateFormat = 'Y-m-d';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;

    protected $fillable = [
        'city_request_id', 'requested_by', 'created_at', 'updated_at'
    ];

    public static function cityRequest($cityid) {

        
        $city= new CityRequest();
        $city->city_request_id=$cityid;
         $city->requested_by=Auth::id();
         $city->save();
        return $city;
    }

}
