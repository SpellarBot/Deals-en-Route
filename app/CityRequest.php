<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CityRequest extends Model {

    protected $table = 'city_request';

    // protected $dateFormat = 'Y-m-d';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;

    protected $fillable = [
        'city','is_review','state_code','country','city_request_id', 'requested_by', 'created_at', 'updated_at'
    ];

    public static function cityRequest($cityid)
    {
        
        $response = \GoogleMaps::load('geocoding')
                ->setParam(['address' => $cityid])
                ->get();
        $data = json_decode($response);
        
        $city = '';
        $state = '';
        $state_code = '';
        $country = '';

        $data = $data->results[0]->address_components;
        foreach ($data as $row)
        {
            if (in_array("locality", $row->types))
            {
                $city = $row->long_name;
            }
            if (in_array("administrative_area_level_1", $row->types))
            {
                $state = $row->long_name;
                $state_code = $row->short_name;
            }
            if (in_array("country", $row->types))
            {
                $country = $row->long_name;
            }
        }
        
        $cityrequest = CityRequest::updateOrCreate(
                        ['requested_by' => Auth::id()], 
                        ['city_request_id' => $cityid, 'city' => $city, 'state_code' => $state_code, 'country' => $country, 'is_review' => 0]
        );


        return $cityrequest;
    }

}
