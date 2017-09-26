<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class UserTransformer {

    public function transform(User $user) {
        return [
            'name' => $user->name,
        ];
    }

    public function transformLogin($user) {

        return [
            'first_name' => $user->userDetail->first_name ?? '',
            'last_name' => $user->userDetail->last_name ?? '',
            'dob' => (!empty($user->userDetail->dob))?Carbon::parse($user->userDetail->dob)->format('Y-m-d'): '',
            'email' => $user->email ?? '',
            'phone' => $user->userDetail->phone ?? '',
            'profile_pic' => (!empty($user->userDetail->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $user->userDetail->profile_pic : "",
            'profile_pic_thumbnail' => (!empty($user->userDetail->profile_pic)) ? URL::to('/storage/app/public/profile_pic/tmp') . '/' . $user->userDetail->profile_pic : "",
            'api_token' => $user->api_token??''
        ];
    }

}
