<?php

namespace App\Http\Services;

trait ResponseTrait {

    public function responseJson($status, $message, $statuscode, $data = '') {
       
        if (!empty($data) || $data==0 ) {
            return response()->json(['status' => $status, 'message' => ucwords($message), 'data' => $data], $statuscode);
        }
        return response()->json(['status' => $status, 'message' => ucwords($message)], $statuscode);
    }

}
