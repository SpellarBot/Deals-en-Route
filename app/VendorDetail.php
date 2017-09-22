<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
    protected $table='vendor_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false; 
    public $primaryKey = 'vendor_id';
    
  
}
