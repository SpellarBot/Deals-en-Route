<?php

namespace App\Http\Services;

trait ResponseTrait {
    
    public function responseJson($status,$message,$statuscode) {	
           
       return response()->json(['status' =>$status, 'message' => ucwords($message)], $statuscode);
            
    }
}
