<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class AdditionalCost extends Model
{
   use \App\Http\Services\CouponTrait;
    public $table = 'additional_cost';
    

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    
    protected $fillable = [
        'id', 'coupon_id', 'user_id', 'coupon_id', 'created_at', 'updated_at', 
        'total_geolocation_utilised','total_geofence_utilised','total_geolocation_buy',
        'total_geofence_buy','is_particular_coupon'
    ];
    
    
    public static function addAdditionalCost(){
        
        
        
    }
    
    public static function getAdditionalCost($data){
        
       $additional= new AdditionalCost();
       $user_access = $additional->userAccess();
        $used_plan= self::usedAdditionalPlan();  

        // geo fence cost
        $plan_geo_fence=$user_access['geofencingtotal'];  
        $total_add_geo_fence=$user_access['additionalgeofencing'];  
        $usedplan = (isset($used_plan) && !empty($used_plan))?$used_plan['geofencetotalused']:0;
        
        if($data['totaldrawn'] >= $plan_geo_fence){
             $totalleftfenced= ($plan_geo_fence + $total_add_geo_fence)- $usedplan;  
             $additional_geo_fence= $data['totaldrawn'] - $totalleftfenced ;
        }
        
        $geofenceaddonprice=PlanAccess::where('plan_id','add_on_geo_fence')->first();
   
        $total_discount=(($additional_geo_fence  * $geofenceaddonprice->price) / $geofenceaddonprice->geofencing);
        return number_format($total_discount, 2);
        
    }
    
     public static function usedAdditionalPlan(){
         
        $addditonal_plan = AdditionalCost::select(DB::raw('SUM(case when is_particular_coupon=0 then total_geofence_utilised else 0 end) as geofencetotalused,
                 SUM(case when is_particular_coupon=1 then total_geolocation_utilised else 0 end) as geofencingtotalused,
                 startdate,enddate,user_id'))
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('user_id', Auth::id())
                ->groupBy('user_id')
                ->get()
                ->toArray();
        return $addditonal_plan;
        
    }
    
}
