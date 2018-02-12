<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use URL;
use App\Http\Services\ImageTrait;

class UserController extends Controller {

    use ImageTrait;

    public function __construct() {
        $this->middleware('auth.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.user.index');
    }

    

 
    /**
     * get the list from master templates table.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function getlist(Request $request) {
        $request = $request->all();
        // get all the contacts
        $templates = User::select(['id', 'email', 'first_name', 'last_name', 'gender','dob', 'is_delete', 'is_active'])
                ->leftJoin('user_detail', 'user_detail.user_id', '=', 'users.id')
                ->where('role', '=', 'user')
                ->deleted();
        $datatables = Datatables::of($templates)
                ->editColumn('dob', function ($user) {

                    return (!empty($user->userDetail->dob)) ? $user->userDetail->dob->format('m/d/Y') : "";
                })->editColumn('full_name', function ($user) {
                    return $user->first_name . " " . $user->last_name;
                })
                ->filterColumn('full_name', function ($query, $keyword) {
                    $query->whereRaw("user_detail.first_name like ?", ["%$keyword%"])
                    ->orwhereRaw("user_detail.last_name like ?", ["%$keyword%"])
                    ->orwhereRaw("concat('',user_detail.last_name,user_detail.first_name) like ?", ["%$keyword%"])
                    ->orwhereRaw("concat('',user_detail.first_name,user_detail.last_name) like ?", ["%$keyword%"]);
                })
                ->filterColumn('dob', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(user_detail.dob,'%d/%m/%Y') like ?", ["%$keyword%"]);
                })
                ->orderColumn('full_name', 'concat("",user_detail.first_name,user_detail.last_name) $1');

        // Global search function

        return $datatables->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $show = 0;
        $users = User::find($id)
                ->leftJoin('user_detail', 'user_detail.user_id', '=', 'users.id')
                ->where('users.id', $id)
                ->first();
        $imagePath = $this->showImage($users->profile_pic, 'profile_pic');
        $categoryList = \App\CouponCategory::categoryListWeb();

        // show the edit form and pass the contact
        return view('admin.user.edit')->with(['users' => $users, 'imagePath' => $imagePath,
                    'categoryList' => $categoryList, 'show' => $show]);
    }

    public function showLinkRequestForm($id) {
        $id = base64_decode($id);
        $users = User::find($id);
        return view('admin.resetpassword')->with(['users' => $users]);
    }

    
    public function setting() {

        $settings = \App\Setting::find(1);

        // show the settings 
        return view('admin.setting')->with(['settings' => $settings]);
    }

}
