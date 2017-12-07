<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAccess extends Model
{
    
   protected $table = 'plan_access';
   public $timestamps = false;
   public $primaryKey = 'id'; 
   
   
    /**
     * Get the vendor detail record associated with the user.
     */
    public function planAccess() {
        return $this->hasOne('App\PlanAccess', 'plan_id', 'created_by');
    }
    
    
   public function getAccess(){
       
       
       
   }
   
   
   
   
    
}
