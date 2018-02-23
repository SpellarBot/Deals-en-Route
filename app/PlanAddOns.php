<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class PlanAddOns extends Model {

    protected $table = 'plan_add_ons';
    public $timestamps = false;
    public $primaryKey = 'id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'user_id', 'plan_id', 'addon_type', 'quantity', 'is_active', 'startdate', 'enddate', 'created_at', 'updated_at'
    ];

    /**
     * Get the vendor detail record associated with the user.
     */
    public static function addOnsInsert($data) {
        $addon = PlanAddOns::create([
                    'user_id' => $data['user_id'],
                    'plan_id' => $data['plan_id'],
                    'addon_type' => $data['addon_type'],
                    'quantity' => $data['quantity'],
                    'startdate' => $data['startdate'],
                    'enddate' => $data['enddate'],
                    'is_active' => self::IS_TRUE
        ]);
        self::addLeftLocation($data['quantity'], $data['addon_type']);
        return $addon;
    }
    public static function addLeftLocation($quantity,$type){
        $vendordetail= \App\VendorDetail::where('user_id', Auth::id())->first();
        if($type == 'geolocation') {  
         $vendordetail->additional_geo_location_total= $quantity + $vendordetail->additional_geo_location_total; 
        }else{
         $vendordetail->additional_geo_fencing_total= $quantity + $vendordetail->additional_geo_fencing_total;   
        }
        
         $vendordetail->save();
    }

}
