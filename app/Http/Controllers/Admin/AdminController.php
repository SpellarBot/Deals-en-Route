<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\CouponRedeem;
use App\Subscription;

class AdminController extends Controller {

    //
    public function userlist()
    {   
        $data['user_list'] = User::where('is_delete', '0')->where('role', 'user')->leftjoin('user_detail', 'users.id', 'user_detail.user_id')->get();
        foreach ($data['user_list'] as $row)
        {
            $row->coupons = CouponRedeem::where('user_id',$row->id)->count();
            $dob = $row->dob;
            $row->age = '-';
            if ($dob)
            {
                $diff = (date('Y') - date('Y', strtotime($dob)));
                $row->age = $diff;
            }
        }
        //echo '<pre>';print_r($data);exit;
        return view('admin.users', $data);
    }
    
    public function vendorlist()
    {   
        $data['user_list'] = User::where('users.is_delete', '0')->where('users.role', 'vendor')->leftjoin('vendor_detail', 'users.id', 'vendor_detail.user_id')->get();
        foreach ($data['user_list'] as $row)
        {
            $sub = Subscription::where('user_id',$row->id)->first();
            $row->sub = '-';
            if($sub){
                $row->sub = $sub->name;
            }
        }
        //echo '<pre>';print_r($data['user_list']);exit;
        return view('admin.businesses', $data);
    }

}
