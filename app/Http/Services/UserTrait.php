<?php

namespace App\Http\Services;

use App\User;

trait UserTrait {
    
    public function createUser() {

        // Get all the brands from the Brands Table.
        Brand::all();
    }
    
    public function generateRandomString(){
       return str_random(30);
    }
    
    public function generateAuthToken(){
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
    
    public function getVendorName($id){
        $vendor= \App\VendorDetail::where('user_id',$id)->first();
        return $vendor;
    }
    
    public function getFbFriendId($id){
        $fb_token= \App\UserDetail::where('fb_token',$id)->first();
        if(!empty($fb_token)){
        return $fb_token->user_id;
        }
    }
}
