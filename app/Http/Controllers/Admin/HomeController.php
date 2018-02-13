<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\PlanAccess;
use App\PaymentInfo;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth.admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['user_count'] = User::where('is_delete','0')->where('role','user')->count();
        $data['vendor_count'] = User::where('is_delete','0')->where('role','vendor')->count();
        $data['plan_count'] = PlanAccess::count();
        $data['payment_count'] = PaymentInfo::where('payment_status','success')->sum('payment_amount');
        //print_r($data);exit;
        return view('admin.dashboard', $data);
    }

}
