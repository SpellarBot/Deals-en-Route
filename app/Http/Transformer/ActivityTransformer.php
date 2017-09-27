<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class ActivityTransformer {
    
    
    public function transformCheckFb($user){
        return [
            'is_fbconnected' => (!empty($user->fb_token)?0:1)
            
         ]; 
    }
    
}

