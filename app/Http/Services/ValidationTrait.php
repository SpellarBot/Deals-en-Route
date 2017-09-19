<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Validator;
use App\User;

trait ResponseTrait {

	
   // send response with json    
    public function responseJson($status,$message,$statuscode) {
           return response()->json(['status' =>$status, 'message' => ucwords($message)], $statuscode);       
    }
}
