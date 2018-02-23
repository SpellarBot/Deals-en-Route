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
use App\DealComments;
use App\Comment;
use App\ReportContent;
use App\City;
use App\CityRequest;
use App\CouponCategory;
use Storage;
use DB;
use App\Http\Services\ImageTrait;
use App\VendorDetail;

class AdminController extends Controller {

    use ImageTrait;

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

    public function userDetail($id)
    {
        $data['user_list'] = User::where('is_delete', '0')->where('id', $id)->leftjoin('user_detail', 'users.id', 'user_detail.user_id')->get();
        foreach ($data['user_list'] as $row)
        {
            $data['coupons'] = CouponRedeem::where('user_id', $id)->join('coupon', 'coupon.coupon_id', 'coupon_redeem.coupon_id')->paginate(10);
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

    public function vendorDetail($id)
    {
        $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->where('vendor_detail.user_id', $id)
                ->first();
        $user_access = $vendor_detail->userAccess();
        $user = \App\Subscription::where('user_id', $id)->first();
        if ($user) {
            $deals_left = $user->getRenewalCoupon($user_access);
            
             $deals_left;
        }
        $additional = new \App\AdditionalCost();
        $total_additional_fencing_left =  $additional->getAdditionalFencing($id);
        $total_additional_location_left =  $additional->getAdditionalLocation($id);
        $total_geofencing = $total_additional_fencing_left + $user_access['basicgeofencing'];
        $total_location = $total_additional_location_left + $user_access['basicgeolocation'];
        

        
        $data = [];
        $data['total_deal']  = $user_access['dealstotal'] - $deals_left;
        $data['used_deal'] = $user_access['dealstotal'];
        
        $geo = VendorDetail::where('user_id', $id)->first();  //echo '<pre> ';     print_r($geo);exit;
        $data['total_geo']  = (int) $geo->additional_geo_fencing_total - $geo->additional_geo_location_used;
        $data['used_geo'] =   (int) $geo->additional_geo_location_used;
        
        $data['total_mile'] = (int)$geo->additional_geo_location_total - $geo->additional_geo_fencing_used;
        $data['used_mile'] =  (int)$geo->additional_geo_fencing_used;
        
//        exit;
       
        $data['vendor_list'] = User::where('users.is_delete', '0')->where('users.id', $id)->leftjoin('vendor_detail', 'vendor_detail.user_id', 'users.id')->leftjoin('subscriptions', 'users.id', 'subscriptions.user_id')->get();
        $data['active_list'] = Coupon::where('created_by', $id)->where('is_active', '1')->paginate(10);
        foreach ($data['active_list'] as $row)
        {
            $row->redeemed = CouponRedeem::where('coupon_id', $row->coupon_id)->count();
        }
        $data['additional_list'] = PlanAddOns::where('user_id', $id)->get();
        //echo'<pre>';print_r($data['active_list']);
        return view('admin.businessesdetails', $data);
    }

    public function businessDetailPdf($id)
    {
        $data = [];
        $data['vendor_list'] = User::where('users.is_delete', '0')->where('users.id', $id)->leftjoin('vendor_detail', 'vendor_detail.user_id', 'users.id')->leftjoin('subscriptions', 'users.id', 'subscriptions.user_id')->get();
        $data['active_list'] = Coupon::where('created_by', $id)->where('is_active', '1')->get();
        foreach ($data['active_list'] as $row)
        {
            $row->redeemed = CouponRedeem::where('coupon_id', $row->coupon_id)->count();
        }
        $data['additional_list'] = PlanAddOns::where('user_id', $id)->get();
        //echo'<pre>';print_r($data['active_list']);
        $pdf = PDF::loadView('admin.business-detail-pdf', $data);
        return $pdf->download('business_details.pdf');
    }

    public function disableUser($id, $type)
    {

        $data = User::where('id', $id)->update(['is_active' => 0]);
        if ($type == 'user')
        {
            return redirect('admin/user-detail/' . $id);
        } else
        {
            return redirect('admin/vendor-detail/' . $id);
        }
    }

    public function activeUser($id, $type)
    {
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
        $data['business_list'] = $data['business_list']->select(['*','users.id as id'])->paginate(10);
        //echo '<pre>';print_r($data['user_list']);exit;
        return view('admin.businesses', $data);
    }

    public function citylist()
    {
        $data['city_list_inactive'] = City::where('is_active', 0)->get();
        $data['city_list_active'] = City::where('is_active', 1)->paginate(10);
        $data['city_request'] = CityRequest::leftjoin('user_detail', 'user_detail.user_id', 'city_request.requested_by')->leftjoin('city', 'city.id', 'city_request.city_request_id')->get(['first_name', 'last_name', 'name']);
        //echo '<pre>';print_r($data['city_request']);exit;
        return view('admin.cities', $data);
    }

    public function activeCity()
    {
        if (Input::get('active_city') != '')
        {
            foreach (Input::get('active_city') as $row)
            {
                $data = City::where('id', $row)->update(['is_active' => 1]);
            }
            return redirect('admin/city');
        }
    }

    public function deactiveCity($id)
    {
        if ($id)
        {
            City::where('id', $id)->update(['is_active' => 0]);
            return redirect('admin/city');
        }
    }

    public function payment()
    {
        $data['vendor_val'] = '';
        $data['payment_type_val'] = '';
        $data['payment_status_val'] = '';
        $data['date_start_val'] = '';
        $data['date_end_val'] = '';
        $data['paylist'] = PaymentInfo::leftjoin('vendor_detail', 'vendor_detail.vendor_id', 'paymentinfo.vendor_id')->leftjoin('users', 'users.id', 'paymentinfo.vendor_id');
        $data['payment_type'] = PaymentInfo::distinct()->get(['payment_type']);
        $data['payment_status'] = PaymentInfo::distinct()->get(['payment_status']);
        $data['vendor_list'] = User::where('role', 'vendor')->leftjoin('vendor_detail', 'vendor_detail.user_id', 'users.id')->get();
        //echo '<pre>';print_r($data['vendor_list']);exit;
        if (Input::get('vendor') != '')
        {
            $data['paylist'] = $data['paylist']->where('paymentinfo.vendor_id', Input::get('vendor'));
            $data['vendor_val'] = Input::get('vendor');
        }
        if (Input::get('payment_type') != '')
        {
            $data['paylist'] = $data['paylist']->where('paymentinfo.payment_type', Input::get('payment_type'));
            $data['payment_type_val'] = Input::get('payment_type');
        }
        if (Input::get('payment_status') != '')
        {
            $data['paylist'] = $data['paylist']->where('paymentinfo.payment_status', Input::get('payment_status'));
            $data['payment_status_val'] = Input::get('payment_status');
        }

        if (Input::get('date_start') != '')
        {
            $start_date = date('Y-m-d H:i:s', strtotime(Input::get('date_start')));
            $end_date = date('Y-m-d H:i:s', strtotime(Input::get('date_end')));
            $data['paylist'] = $data['paylist']->whereBetween('created_at', [$start_date, $end_date]);
            $data['date_start_val'] = Input::get('date_start');
            $data['date_end_val'] = Input::get('date_end');
        }
        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {
            $data['paylist'] = $data['paylist']->get();
            $pdf = PDF::loadView('admin.payments-pdf', $data);
            return $pdf->download('payment-list.pdf');
        }

        $data['paylist'] = $data['paylist']->paginate(10);
        //echo '<pre>';print_r($data['paylist']);exit;
        return view('admin.payments', $data);
    }

    public function reportedContent()
    {

        $data['is_activity'] = 0;
        if (Input::get('is_activity') == 0)
        {
            $data['report_list'] = ReportContent::where('report_content.type', 0)->leftjoin('comment', 'comment.comment_id', 'report_content.comment_id')->leftjoin('user_detail AS a', 'a.user_id', 'comment.parent_id')->leftjoin('user_detail AS b', 'b.user_id', 'comment.parent_id')->select(['report_content.*', 'comment.*', 'a.user_id as aid', 'a.first_name as c_firstname', 'a.last_name as c_lastname', 'b.user_id as bid', 'b.first_name as o_firstname', 'b.last_name as o_lastname']);
        } else
        {
            $data['is_activity'] = 1;
            $data['report_list'] = ReportContent::where('report_content.type', 1)->leftjoin('deal_comments', 'deal_comments.id', 'report_content.comment_id')->leftjoin('user_detail AS a', 'a.user_id', 'deal_comments.comment_by')->leftjoin('user_detail AS b', 'b.user_id', 'deal_comments.parent_id')->select(['report_content.*', 'deal_comments.*', 'a.user_id as aid', 'a.first_name as c_firstname', 'a.last_name as c_lastname', 'b.user_id as bid', 'b.first_name as o_firstname', 'b.last_name as o_lastname']);
        }

        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {
            $data['report_list'] = $data['report_list']->get();
            $pdf = PDF::loadView('admin.report-pdf', $data);
            return $pdf->download('report-content.pdf');
        } else
        {
            $data['report_list'] = $data['report_list']->paginate(10);
        }

        return view('admin.reported-content', $data);
    }

    use \App\Http\Services\MailTrait;

    public function resendInvoice()
    {
        if (Input::get('email') != '' && Input::get('invoice') != '')
        {
            $array_mail = ['to' => Input::get('email'), //Input::get('email'),
                'type' => 'resend_mail',
                'data' => ['confirmation_code' => 'Test'],
                'invoice' => storage_path('app/pdf/'.Input::get('invoice'))
            ];
            $this->sendMail($array_mail);
            $data[] = 'success';
            return $data;
        }
        $data[] = 'error';
        return $data;
    }

    public function categories()
    {
        $data['requested_list'] = CouponCategory::where('is_requested', 1)->where('is_active', 0)->where('is_delete', 0)->get();
        //echo '<pre>';print_r($data['requested_list']);exit;
        $data['category_list_active'] = CouponCategory::where('is_active', 1)->where('is_delete', 0)->paginate(10);
        //echo '<pre>';print_r($data['category_list_active']);exit;
        return view('admin.categories', $data);
    }

    public function deactiveCategory($id)
    {
        if ($id)
        {
            CouponCategory::where('category_id', $id)->update(['is_active' => 0]);
            return redirect('admin/categories');
        }
    }

    public function categotyStatus(request $request)
    {
        if (Input::get('cat_id') != '' && Input::get('status') != '')
        {
            if (Input::get('status') == 0)
            {
                $data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['is_active' => 0, 'reject_reason' => Input::get('comment'), 'is_delete' => '1']);
                $array_mail = ['to' => 'nilay@solulab.com',
                    'type' => 'category_reject',
                    'data' => ['reason' => Input::get('comment'),'name' => Input::get('cat_name')]
                ];
                $this->sendMail($array_mail);
            } else
            {
                if ($request->file('logo'))
                {
                    $upload = $this->categoryImageWeb($request->file('logo'), 'category_image', $request->input('cat_id'));
                }
                $data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['is_active' => 1]);
                $array_mail = ['to' => 'nilay@solulab.com',
                    'type' => 'category_accept',
                    'data' => ['name' => Input::get('cat_name')]
                ];
                $this->sendMail($array_mail);
            }
            return redirect('admin/categories');
        }
    }

}
