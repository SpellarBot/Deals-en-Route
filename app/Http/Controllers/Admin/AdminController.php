<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\CouponRedeem;
use App\Subscription;
use Illuminate\Support\Facades\Input;
use PDF;
use App\Coupon;
use App\PlanAddOns;
use App\PaymentInfo;

class AdminController extends Controller {

    //
    public function userlist()
    {

        $data['signuptype'] = '';
        $data['userstatus'] = '';
        $data['user_list'] = [];
        $data['user_search'] = '';

        $data['user_list'] = User::where('is_delete', '0')->where('role', 'user')->leftjoin('user_detail', 'users.id', 'user_detail.user_id');
        if (Input::get('signuptype') != '')
        {
            $data['signuptype'] = Input::get('signuptype');
            if ($data['signuptype'] == 'facebook')
            {
                $data['user_list'] = $data['user_list']->where('fb_token', '!=', '');
            } else if ($data['signuptype'] == 'google')
            {
                $data['user_list'] = $data['user_list']->where('google_token', '!=', '');
            } else if ($data['signuptype'] == 'twitter')
            {
                $data['user_list'] = $data['user_list']->where('twitter_token', '!=', '');
            } else
            {
                $data['user_list'] = $data['user_list']->where('twitter_token', '=', null)->where('google_token', '=', null)->where('fb_token', '=', null);
            }
        }
        if (Input::get('userstatus') != '')
        {
            $data['userstatus'] = Input::get('userstatus');
            $data['user_list'] = $data['user_list']->where('is_active', $data['userstatus']);
        }
        if (Input::get('user_search') != '')
        {
            $data['user_search'] = Input::get('user_search');
            $data['user_list'] = $data['user_list']->where('first_name', 'LIKE', '%' . $data['user_search'] . '%')->orwhere('last_name', 'LIKE', '%' . $data['user_search'] . '%');
        }
        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {
            $data['user_list'] = $data['user_list']->get();
        } else
        {
            $data['user_list'] = $data['user_list']->paginate(10);
        }
        foreach ($data['user_list'] as $row)
        {
            $row->coupons = CouponRedeem::where('user_id', $row->id)->count();
            $dob = $row->dob;
            $row->age = '-';
            if ($dob)
            {
                $diff = (date('Y') - date('Y', strtotime($dob)));
                $row->age = $diff;
            }
        }
        //echo '<pre>';print_r($data);exit;
        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {

            $pdf = PDF::loadView('admin.users_pdf', $data);
            return $pdf->download('users_pdf.pdf');
        }

        return view('admin.users', $data);
    }
    
    public function userDetail($id){
        $data['user_list'] = User::where('is_delete', '0')->where('id', $id)->leftjoin('user_detail', 'users.id', 'user_detail.user_id')->get();
        foreach ($data['user_list'] as $row)
        {
            $data['coupons'] = CouponRedeem::where('user_id', $id)->join('coupon','coupon.coupon_id','coupon_redeem.coupon_id')->paginate(10);
            $row->coupons = count($data['coupons']);
            $dob = $row->dob;
            $row->age = '-';
            if ($dob)
            {
                $diff = (date('Y') - date('Y', strtotime($dob)));
                $row->age = $diff;
            }
        }
        //echo '<pre>';print_r($data['coupons']);
        return view('admin.userdetails', $data);
    }
    
    public function vendorDetail($id){
        $data = [];
        $data['vendor_list'] = User::where('users.is_delete', '0')->where('users.id', $id)->leftjoin('vendor_detail', 'vendor_detail.user_id', 'users.id')->leftjoin('subscriptions', 'users.id', 'subscriptions.user_id')->get();
        $data['active_list'] = Coupon::where('created_by',$id)->where('is_active','1')->paginate(10);
        foreach($data['active_list'] as $row){
            $row->redeemed = CouponRedeem::where('coupon_id', $row->coupon_id)->count();
        }
        $data['additional_list'] = PlanAddOns::where('user_id',$id)->get();
        //echo'<pre>';print_r($data['active_list']);
        return view('admin.businessesdetails', $data);
    }
    
    public function businessDetailPdf($id){
        $data = [];
        $data['vendor_list'] = User::where('users.is_delete', '0')->where('users.id', $id)->leftjoin('vendor_detail', 'vendor_detail.user_id', 'users.id')->leftjoin('subscriptions', 'users.id', 'subscriptions.user_id')->get();
        $data['active_list'] = Coupon::where('created_by',$id)->where('is_active','1')->get();
        foreach($data['active_list'] as $row){
            $row->redeemed = CouponRedeem::where('coupon_id', $row->coupon_id)->count();
        }
        $data['additional_list'] = PlanAddOns::where('user_id',$id)->get();
        //echo'<pre>';print_r($data['active_list']);
        $pdf = PDF::loadView('admin.business-detail-pdf', $data);
        return $pdf->download('business_details.pdf');
    }
    
    public function disableUser($id, $type){
       
            $data = User::where('id', $id)->update(['is_active' => 0]);
        if ($type == 'user')
        {
            return redirect('admin/user-detail/' . $id);
        } else
        {
            return redirect('admin/vendor-detail/' . $id);
        }
    }
    
    public function activeUser($id, $type){
        $data = User::where('id', $id)->update(['is_active' => 1]);
         if ($type == 'user')
        {
            return redirect('admin/user-detail/' . $id);
        } else
        {
            return redirect('admin/vendor-detail/' . $id);
        }
    }
    
    public function offerlistPdf($id)
    {
        $data['user_list'] = User::where('is_delete', '0')->where('id', $id)->leftjoin('user_detail', 'users.id', 'user_detail.user_id')->get();
        foreach ($data['user_list'] as $row)
        {
            $data['coupons'] = CouponRedeem::where('user_id', $id)->join('coupon', 'coupon.coupon_id', 'coupon_redeem.coupon_id')->get();
            $row->coupons = count($data['coupons']);
            $dob = $row->dob;
            $row->age = '-';
            if ($dob)
            {
                $diff = (date('Y') - date('Y', strtotime($dob)));
                $row->age = $diff;
            }
        }
        $pdf = PDF::loadView('admin.offer_list_pdf', $data);
        return $pdf->download('offer_list_pdf.pdf');
    }

    public function vendorlist()
    {
        $data['pcg_type'] = '';
        $data['status'] = '';
        $data['business_search'] = '';
        $data['business_list'] = User::where('users.is_delete', '0')->where('users.role', 'vendor')->leftjoin('vendor_detail', 'users.id', 'vendor_detail.user_id')->leftjoin('subscriptions', 'users.id', 'subscriptions.user_id');
        //echo '<pre>';print_r($data['business_list']);exit;

        if (Input::get('business_search') != '')
        {
            $data['business_search'] = Input::get('business_search');
            $data['business_list'] = $data['business_list']->where('vendor_name', 'LIKE', '%' . $data['business_search'] . '%');
        }
        if (Input::get('status') != '')
        {
            $data['status'] = Input::get('status');
            $data['business_list'] = $data['business_list']->where('is_active', $data['status']);
        }

        if (Input::get('pcg_type') != '')
        {
            $data['pcg_type'] = Input::get('pcg_type');
            $data['business_list'] = $data['business_list']->where('stripe_plan', $data['pcg_type']);
        }

        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {
            $data['business_list'] = $data['business_list']->get();
            $pdf = PDF::loadView('admin.businesses_pdf', $data);
            return $pdf->download('Business_pdf.pdf');
        }
        $data['business_list'] = $data['business_list']->paginate(10);
        //echo '<pre>';print_r($data['user_list']);exit;
        return view('admin.businesses', $data);
    }

    public function citylist()
    {
        $data = [];
        return view('admin.cities', $data);
    }

    public function payment()
    {
        $data['paylist'] = PaymentInfo::leftjoin('vendor_detail','vendor_detail.vendor_id','paymentinfo.vendor_id');
        
        if(Input::get('is_pdf') != '' || Input::get('is_pdf') != '' ){
            
        }
        
        $data['paylist'] = $data['paylist']->paginate(10);
        
        if(Input::get('is_pdf') != '' && Input::get('is_pdf') > 0){}
        
        return view('admin.payments', $data);
    }

    public function reportedContent()
    {
        $data['user_list'] = User::where('is_delete', '0')->where('role', 'user')->leftjoin('user_detail', 'users.id', 'user_detail.user_id')->get();
        return view('admin.reported-content', $data);
    }

}
