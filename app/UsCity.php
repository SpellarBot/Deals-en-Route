<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsCity extends Model
{
    protected $table = 'us_cities';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;

    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;
    
    
    
    public function getCityList(){
        
        $city= UsCity::find();
        
    }
    
    
}
