<?php

namespace App\Http\Services;

use App\User;

trait VendorTrait {

    public function createUser() {

        // Get all the brands from the Brands Table.
        Brand::all();
    }

    public function generateRandomString() {
        return str_random(30);
    }

    public function generatePassword() {
        return str_random(8);
    }

    public function generateAuthToken() {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    public function getVendorName($id) {
        $vendor = \App\VendorDetail::where('user_id', $id)->first();
        return $vendor;
    }

    public function getFbFriendId($id) {
        $fb_token = \App\UserDetail::where('fb_token', $id)->first();
        if (!empty($fb_token)) {
            return $fb_token->user_id;
        }
    }

    public function getUserDetail($id) {
        $vendor = \App\VendorDetail::where('user_id', $id)->first();
        return $vendor;
    }

    public function finalNotificationMessage($item) {

        $userfrom = User::find($item->from_id);
        $tofrom = User::find($item->notifiable_id);
        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
        $toid = (!empty($tofrom) ? $tofrom->userDetail->first_name . " " . $tofrom->userDetail->last_name : '');
        $coupon_name = \App\Coupon::getCouponDetail(['coupon_id' => $item->coupon_id]);
        $find = ['{{to_name}}', '{{from_name}}', '{{coupon_name}}'];
        $replace = [$toid, $fromid, empty($coupon_name) ? "" : $coupon_name->coupon_name];
        $message = str_replace($find, $replace, $item->message);
        return $message;
    }

}
