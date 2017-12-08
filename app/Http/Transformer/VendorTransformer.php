<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class VendorTransformer {

    use \App\Http\Services\VendorTrait;

    public function transform(User $user) {
        return [
            'name' => $user->name,
        ];
    }

    public function transformLogin($user) {
        return [
            'user_id'=>$user->vendor->user_id ?? '',
            'vendor_name' => $user->vendor->vendor_name ?? '',
            'vendor_address' => $user->vendor->vendor_address ?? '',
            'email' => $user->email ?? '',
            'vendor_phone' => $user->vendor->vendor_phone ?? '',
            'vendor_logo' => (!empty($user->vendor->vendor_logo)) ? URL::to($user->vendor->vendor_logo): "",
            'profile_pic_thumbnail' => (!empty($user->vendor->vendor_logo)) ? URL::to($user->vendor->vendor_logo) : "",
            'api_token' => $user->api_token ?? ''
        ];
    }

    public function transformNotification($data) {

        $var = [];
        foreach ($data as $item) {
            $fromuser = \App\User::find($item->from_id);
            if (!empty($fromuser)) {
                $profile = URL::to('/storage/app/public/profile_pic') . '/' . $fromuser->userDetail->profile_pic;
            } else {
                $profile = '';
            }
            $touser = \App\User::find($item->notifiable_id);

            $fmessage = $this->finalNotificationMessage($item);
            $var[] = [
                'notification_id' => $item->id ?? '',
                'notification_message' => $fmessage ?? '',
                'notification_image' => $profile,
                'is_read' => $item->is_read ?? '',
                'to_name' => (!empty($touser) ? $touser->userDetail->first_name . ' ' . $touser->userDetail->last_name : '')
            ];
        }
        return ['has_page' => $data->hasMorePages(), 'current_page' => $data->currentPage(), 'listing' => $var];
    }

}
