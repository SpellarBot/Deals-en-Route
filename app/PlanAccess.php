<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAccess extends Model
{
    
   protected $table = 'plan_access';
   public $timestamps = false;
   public $primaryKey = 'id'; 
     protected $fillable = [
        'plan_id', 'geolocation', 'deals', 'geofencing', 'analytics_age',
         'analytics_gender','analytics_coupon_views','analytics_potential_view'.
         'price'
    ];
   
    /**
     * Get the vendor detail record associated with the user.
     */
    public function planAccess() {
        return $this->hasOne('App\PlanAccess', 'plan_id', 'created_by');
    }
    
    
   public function getAccess(){
       
       
       
   }
   
   
   
   
    
}
