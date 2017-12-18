<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class UserTransformer {

    use \App\Http\Services\UserTrait;

    public function transform(User $user) {
        return [
            'name' => $user->name,
        ];
    }

    public function transformLogin($user) {

        return [
            'user_id' => $user->id,
            'first_name' => $user->userDetail->first_name ?? '',
            'last_name' => $user->userDetail->last_name ?? '',
            'dob' => (!empty($user->userDetail->dob)) ? Carbon::parse($user->userDetail->dob)->format('Y-m-d') : '',
            'email' => $user->email ?? '',
            'phone' => $user->userDetail->phone ?? '',
            'profile_pic' => (!empty($user->userDetail->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $user->userDetail->profile_pic : "",
            'profile_pic_thumbnail' => (!empty($user->userDetail->profile_pic)) ? URL::to('/storage/app/public/profile_pic/tmp') . '/' . $user->userDetail->profile_pic : "",
            'api_token' => $user->api_token ?? '',
            'notification_new_offer' => $user->userDetail->notification_new_offer ?? 0,
            'notification_recieve_offer' => $user->userDetail->notification_recieve_offer ?? 0,
            'notification_fav_expire' => $user->userDetail->notification_fav_expire ?? 0,
        ];
    }

    public function transformNotification($data) {

        $var = [];
        foreach ($data as $item) {
            $fromuser = \App\User::find($item->from_id);
            $coupon= \App\Coupon::find( $item->coupon_id);
             if (!empty($fromuser) && !empty($fromuser->userDetail)) {
                $profile = URL::to('/storage/app/public/profile_pic') . '/' . $fromuser->userDetail->profile_pic;
            } else {
               $profile = $coupon->vendorDetail->vendor_logo;
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
