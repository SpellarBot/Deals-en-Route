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
    use \App\Http\Services\MailTrait;

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    //
    public function userlist()
    {

        $data['signuptype'] = '';
        $data['userstatus'] = '';
        $data['user_list'] = [];
        $data['user_search'] = '';

        $data['user_list'] = User::where('is_delete', '0')->where('role', 'user')->leftjoin('user_detail', 'users.id', 'user_detail.user_id');

        if (Input::get('userstatus') != '')
        {
            $data['userstatus'] = Input::get('userstatus');
            $data['user_list'] = $data['user_list']->where('is_active', $data['userstatus']);
        }
        if (Input::get('user_search') != '')
        {
            $data['user_search'] = Input::get('user_search');
            $data['user_list'] = $data['user_list']->where(function($q) {
                $q->where('first_name', 'LIKE', '%' . Input::get('user_search') . '%')->orwhere('last_name', 'LIKE', '%' . Input::get('user_search') . '%');
            });
        }
        if (Input::get('signuptype') != '')
        {
            $data['signuptype'] = Input::get('signuptype');
            if ($data['signuptype'] == 'facebook')
            {
                $data['user_list'] = $data['user_list']->where('user_detail.fb_token', '!=', '');
            } else if ($data['signuptype'] == 'google')
            {
                $data['user_list'] = $data['user_list']->where('user_detail.google_token', '!=', '');
            } else if ($data['signuptype'] == 'twitter')
            {
                $data['user_list'] = $data['user_list']->where('user_detail.twitter_token', '!=', '');
            } else
            {
                $data['user_list'] = $data['user_list']->where('user_detail.twitter_token', '=', null)->where('user_detail.google_token', '=', null)->where('user_detail.fb_token', '=', null);
            }
        }
        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {
            $data['user_list'] = $data['user_list']->orderby('users.id', 'DESC')->get();
        } else
        {
            $data['user_list'] = $data['user_list']->orderby('users.id', 'DESC')->paginate(10);
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
                ->join('subscriptions', 'subscriptions.stripe_id', 'stripe_users.stripe_id')
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('vendor_detail.user_id', $id)
                ->first();

        $add_ons = \App\PlanAddOns::select(DB::raw('SUM(case when addon_type="geolocation" then quantity else 0 end) as geolocationtotal,
                 SUM(case when addon_type="geofencing" then quantity else 0 end) as geofencingtotal,
                 SUM(case when addon_type="deals" then quantity else 0 end) as dealstotal,startdate,enddate,user_id'))
                ->where('user_id', $id)
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->get();
        if (empty($vendor_detail))
        {
            $array['geolocationtotal'] = 0;
            $array['geofencingtotal'] = 0;
            $array['dealstotal'] = 0;
        } else
        {
            $currentpackagedeal = $vendor_detail->userSubscription[0]->deals + $add_ons[0]->dealstotal;
            $previousleftdeal = $vendor_detail->deals_used;
            $totaldealsleft = $currentpackagedeal - $previousleftdeal;
            $array['geolocationtotal'] = $add_ons[0]->geolocationtotal + $vendor_detail->userSubscription[0]->geolocation;
            $array['geofencingtotal'] = $add_ons[0]->geofencingtotal + $vendor_detail->userSubscription[0]->geofencing;
            $array['dealstotal'] = $totaldealsleft;
            $array['additionalgeolocation'] = $add_ons[0]->geolocationtotal;
            $array['additionalgeofencing'] = $add_ons[0]->geofencingtotal;
            $array['basicgeolocation'] = $vendor_detail->userSubscription[0]->geolocation;
            $array['basicgeofencing'] = $vendor_detail->userSubscription[0]->geofencing;
        }
        $deals_left = 0;
        $user = \App\Subscription::where('user_id', $id)->first();
        if ($user)
        {
            $deals_left = $user->getRenewalCoupon($array);
        }
//        echo '<pre>';
//        print_r($array);
//        exit;
        $data = [];
        $data['total_deal'] = $array['dealstotal'] - $deals_left;
        $data['used_deal'] = $array['dealstotal'];

        $geo = VendorDetail::where('user_id', $id)->first();  //echo '<pre> ';     print_r($geo);exit;
        $data['total_geo'] = (int) $geo->additional_geo_fencing_total - $geo->additional_geo_location_used;
        $data['used_geo'] = (int) $geo->additional_geo_location_used;

        $data['total_mile'] = (int) $geo->additional_geo_location_total - $geo->additional_geo_fencing_used;
        $data['used_mile'] = (int) $geo->additional_geo_fencing_used;

//        exit;

        $data['vendor_list'] = User::select(['*', 'users.id as id'])->where('users.is_delete', '0')->where('users.id', $id)->leftjoin('vendor_detail', 'vendor_detail.user_id', 'users.id')->leftjoin('subscriptions', 'users.id', 'subscriptions.user_id')->get();
        $data['active_list'] = Coupon::where('created_by', $id)->where('is_active', '1')->paginate(10);
        foreach ($data['active_list'] as $row)
        {
            $row->redeemed = CouponRedeem::where('coupon_id', $row->coupon_id)->count();
        }
        $data['additional_list'] = PlanAddOns::where('user_id', $id)->get();
        //echo'<pre>';print_r($data['vendor_list']);
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
        //echo'<pre>';print_r($data);exit;
        $pdf = PDF::loadView('admin.business-detail-pdf', $data);
        return $pdf->download('business_details.pdf');
    }

    public function disableUser($id, $type)
    {

        $data = User::where('id', $id)->update(['is_active' => 0, 'api_token' => '']);
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
            $data['business_list'] = $data['business_list']->orderby('users.id', 'DESC')->get();
            $pdf = PDF::loadView('admin.businesses_pdf', $data);
            return $pdf->download('Business_pdf.pdf');
        }
        $data['business_list'] = $data['business_list']->select(['*', 'users.id as id'])->orderby('users.id', 'DESC')->paginate(10);
        //echo '<pre>';print_r($data['business_list']);exit;
        return view('admin.businesses', $data);
    }

    public function citylist()
    {
        $data['msg'] = '';
        $data['class'] = '';
        if (Input::get('msg'))
        {
            $data['msg'] = Input::get('msg');
        }
        $data['city_list_inactive'] = City::where('is_active', 0)->get();
        $data['decline_city'] = City::where('is_active', 0)->where('is_cancel', 1)->get();
        foreach ($data['decline_city'] as $row)
        {
            $row->count = CityRequest::where('city', $row->name)->where('state_code', $row->state_code)->where('country', $row->county)->where('is_review', 1)->count();
        }
        //echo '<pre>';print_r($data['decline_city']);exit;
        $data['city_list_active'] = City::where('is_active', 1)->get();
        $data['city_request'] = CityRequest::where('is_review', 0)->groupby('city_request_id')->select(['*', DB::raw('COUNT(city_request_id) as count')])->orderby('id', 'DESC')->get();
        //echo '<pre>';print_r($data['city_request']);exit;
        return view('admin.cities', $data);
    }

    function getRequestUser()
    {
        //print_r( Input::get());exit;
        $city = '';
        $state = '';
        $country = '';
        $is_review = Input::get('is_review');
        if (Input::get('city'))
        {
            $city = Input::get('city');
        }
        if (Input::get('state'))
        {
            $state = Input::get('state');
        }
        if (Input::get('country'))
        {
            $country = Input::get('country');
        }

        $data = CityRequest::where('city', $city)
                ->where('state_code', $state)
                ->where('country', $country)
                ->where('is_review', $is_review)
                ->leftjoin('user_detail', 'user_detail.user_id', 'city_request.requested_by')
                ->select(['first_name', 'last_name', 'city_request_id AS name', DB::raw('DATE_FORMAT(city_request.created_at, "%m-%d-%Y") as date')])
                ->orderby('city_request.id', 'DESC')
                ->get();
        return $data;
    }

    public function activeCity()
    {
        if (Input::get('active_city') != '')
        {
            $response = \GoogleMaps::load('geocoding')
                    ->setParam(['address' => Input::get('active_city')])
                    ->get();
            $data = json_decode($response);
            //echo '<pre>';


            $city = '';
            $state = '';
            $state_code = '';
            $country = '';

            $data = $data->results[0]->address_components;
            foreach ($data as $row)
            {
                if (in_array("locality", $row->types))
                {
                    $city = $row->long_name;
                }
                if (in_array("administrative_area_level_1", $row->types))
                {
                    $state = $row->long_name;
                    $state_code = $row->short_name;
                }
                if (in_array("country", $row->types))
                {
                    $country = $row->long_name;
                }
            }

            $mailuser = CityRequest::where('city', $city)
                    ->where('state_code', $state_code)
                    ->where('country', $country)
                    ->where('is_review', 0)
                    ->leftjoin('users', 'users.id', 'city_request.requested_by')
                    ->get(['users.email']);

            if (Input::get('is_cancel'))
            {
                $check = City::where('name', $city)->where('state_code', $state_code)->where('county', $country)->get();
                if (count($check) > 0)
                {
                    $this->citymail($mailuser, 'Your request for city <span style="color: red;">`' . $city . '`</span> has been decline.');
                    CityRequest::where('city', $city)->where('state_code', $state_code)->where('country', $country)->update(['is_review' => 1]);

                    return redirect('admin/city?msg=City Already canceled !&class=alert-warning');
                } else
                {
                    $iQuery = City::insert(['name' => $city, 'state' => $state, 'state_code' => $state_code, 'county' => $country, 'is_active' => 0, 'is_cancel' => 1]);

                    $this->citymail($mailuser, 'Your request for city <span style="color: red;">`' . $city . '`</span> has been decline.');
                    CityRequest::where('city', $city)->where('state_code', $state_code)->where('country', $country)->update(['is_review' => 1]);

                    return redirect('admin/city?msg=Added Sucessfully !&class=alert-success');
                }
            }

            $check = City::where('name', $city)->where('state_code', $state_code)->where('county', $country)->first();
            if (count($check) > 0)
            {
                if ($check->is_cancel == 1)
                {
                    $this->citymail($mailuser, 'Your request for city <span style="color: Green;">`' . $city . '`</span> has been accepted.');
                    CityRequest::where('city', $city)->where('state_code', $state_code)->where('country', $country)->update(['is_review' => 1]);
                    City::where('name', $city)->where('state_code', $state_code)->where('county', $country)->update(['is_cancel' => 0, 'is_active' => 1]);
                    return redirect('admin/city?msg=Added Sucessfully !&class=alert-success');
                }
                return redirect('admin/city?msg=City Already Exist !&class=alert-warning');
            } else
            {
                $iQuery = City::insert(['name' => $city, 'state' => $state, 'state_code' => $state_code, 'county' => $country, 'is_active' => 1]);
                CityRequest::where('city', $city)->where('state_code', $state_code)->where('country', $country)->update(['is_review' => 1]);

                $this->citymail($mailuser, 'Your request for city <span style="color: Green;">`' . $city . '`</span> has been accepted.');
                return redirect('admin/city?msg=Added Sucessfully !&class=alert-success');
            }
        }
    }

    public function citymail($data, $status)
    {

        foreach ($data as $row)
        {
            //echo $row->email;
            $array_mail = ['to' => 'naresh@solulab.com', // $row->email,
                'type' => 'city_status',
                'data' => ['status' => $status]
            ];
            $this->sendMail($array_mail);
        }
    }

    public function deactiveCity($id)
    {
        if ($id > 0)
        {
            City::where('id', $id)->delete();
            return redirect('admin/city?msg=Removed Successfully !&class=alert-danger');
        }
    }

    public function payment()
    {
        $data['vendor_val'] = '';
        $data['payment_type_val'] = '';
        $data['payment_status_val'] = '';
        $data['date_start_val'] = '';
        $data['date_end_val'] = '';
        $data['paylist'] = PaymentInfo::leftjoin('vendor_detail', 'vendor_detail.user_id', 'paymentinfo.vendor_id')->leftjoin('users', 'users.id', 'paymentinfo.vendor_id');
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
            $start_date = date('Y-m-d', strtotime(Input::get('date_start')));
            $end_date = date('Y-m-d', strtotime(Input::get('date_end')));
            $data['paylist'] = $data['paylist']->where(\DB::raw('DATE(paymentinfo.created_at)'), '>=', $start_date)->where(\DB::raw('DATE(paymentinfo.created_at)'), '<=', $end_date); //whereBetween('paymentinfo.created_at', [$start_date, $end_date]);



            $data['date_start_val'] = Input::get('date_start');
            $data['date_end_val'] = Input::get('date_end');
        }
        if (Input::get('is_pdf') != '' && Input::get('is_pdf') > 0)
        {
            $data['paylist'] = $data['paylist']->select(['*', 'paymentinfo.created_at as created_at'])->orderby('paymentinfo.created_at', 'DESC')->get();
            $pdf = PDF::loadView('admin.payments-pdf', $data);
            return $pdf->download('payment-list.pdf');
        }

        $data['paylist'] = $data['paylist']->select(['*', 'paymentinfo.created_at as created_at'])->orderby('paymentinfo.created_at', 'DESC')->paginate(10);
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

    public function resendInvoice()
    {
        if (Input::get('email') != '' && Input::get('invoice') != '')
        {
            $array_mail = ['to' => Input::get('email'), //Input::get('email'),
                'type' => 'resend_mail',
                'data' => ['confirmation_code' => 'Test'],
                'invoice' => storage_path('app/pdf/' . Input::get('invoice'))
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
        $data['msg'] = '';
        if (Input::get('msg'))
        {
            $data['msg'] = Input::get('msg');
        }
        $data['requested_list'] = CouponCategory::where('is_requested', 1)->where('is_active', 0)->where('is_delete', 0)->get();
        //echo '<pre>';print_r($data['requested_list']);exit;
        $data['category_list_active'] = CouponCategory::where('is_active', 1)->where('is_delete', 0)->orderby('category_id', 'DESC')->paginate(10);
        //echo '<pre>';print_r($data['category_list_active']);exit;
        return view('admin.categories', $data);
    }

    public function deactiveCategory($id)
    {
        if ($id)
        {
            CouponCategory::where('category_id', $id)->update(['is_active' => 0, 'is_delete' => 1]);
            $msg = 'Category Deleted Successfully';
            return redirect('admin/categories?msg=' . $msg);
        }
    }

    public function categotyStatus(request $request)
    {
//        print_r($request->input());
//        exit;

        if ($request->input('cat_id'))
        {
            if ($request->file('logo'))
            {
                $ex = $request->file('logo')->getClientOriginalExtension();
                $upload = $this->categoryImageWeb($request->file('logo'), 'category_image', $request->input('cat_id'));
                $data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['category_name' => $request->input('cat_name'), 'is_active' => 1, 'category_logo_image' => $request->input('cat_id') . '.' . $ex, 'category_image' => $request->input('cat_id') . '.' . $ex]);
                $msg = 'Category Updated Successfully';
                return redirect('admin/categories?msg=' . $msg);
            } else
            {
                $data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['category_name' => $request->input('cat_name')]);
                $msg = 'Category Updated Successfully';
                return redirect('admin/categories?msg=' . $msg);
            }
        } else
        {
            $ex = '';
            if ($request->file('logo'))
            {
                $ex = $request->file('logo')->getClientOriginalExtension();
                $qry = CouponCategory::orderby('category_id','DESC')->first();
                $id = $qry->category_id + 1;
                $upload = $this->categoryImageWeb($request->file('logo'), 'category_image', $id);
            }
            $data['requested_list'] = CouponCategory::insert(['category_name' => $request->input('cat_name'),
                        'is_requested' => '0',
                        'category_image' => $id.'.'.$ex,
                        'category_logo_image' => $id.'.'.$ex,
                        'requested_by' => '',
                        'is_active' => '1',
                        'is_delete' => '0',
            ]);
            $msg = 'Category Added Successfully';
            return redirect('admin/categories?msg=' . $msg);
        }
        //$data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['category_name' => $request->input('cat_name'),'is_active' => 1, 'category_logo_image' => $request->input('cat_id') . '.' . $ex, 'category_image' => $request->input('cat_id') . '.' . $ex]);
//        if (Input::get('cat_id') != '' && Input::get('status') != '')
//        {
//            if (Input::get('status') == 0)
//            {
//                $data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['is_active' => 0, 'reject_reason' => Input::get('comment'), 'is_delete' => '1']);
//                $array_mail = ['to' => Input::get('email'),
//                    'type' => 'category_reject',
//                    'data' => ['reason' => Input::get('comment'), 'name' => Input::get('cat_name')]
//                ];
//                $this->sendMail($array_mail);
//                $msg = 'Category Rejected Successfully';
//            } else
//            {
//                if ($request->file('logo'))
//                {
//                    $ex = $request->file('logo')->getClientOriginalExtension();
//                    $upload = $this->categoryImageWeb($request->file('logo'), 'category_image', $request->input('cat_id'));
//                }
//                $data['requested_list'] = CouponCategory::where('category_id', Input::get('cat_id'))->update(['is_active' => 1, 'category_logo_image' => $request->input('cat_id') . '.' . $ex, 'category_image' => $request->input('cat_id') . '.' . $ex]);
//                $array_mail = ['to' => Input::get('email'),
//                    'type' => 'category_accept',
//                    'data' => ['name' => Input::get('cat_name')]
//                ];
//                $this->sendMail($array_mail);
//                $msg = 'Category Added Successfully';
//            }
//            return redirect('admin/categories?msg=' . $msg);
//        }
    }

}
