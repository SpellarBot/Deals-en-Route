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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $show = 1;
        $categoryList = \App\CouponCategory::categoryListWeb();
        // show the edit form and pass the contact
        return view('admin.user.create')->with(['categoryList' => $categoryList,
                    'show' => $show]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {
        DB::beginTransaction();
        try {
            // process the store
            $data = $request->all();

            $user_detail = \App\UserDetail::createUser($data);
            $file = Input::file('profile_pic');

            if (!empty($file)) {
                $this->addImageWeb($file, $user_detail, 'profile_pic');
            }
        } catch (\Exception $e) {
            DB::rollback();
            //  throw $e;
            Session::flash('message', \Config::get('constants.APP_ERROR'));
            return Redirect::to('admin/user/create');
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        // redirect
        Session::flash('message', \Config::get('constants.USER_CREATED'));
        return Redirect::to('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $show = 1;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id) {

        DB::beginTransaction();
        try {
            // process the store
            $data = $request->all();
            $user_detail = \App\UserDetail::updateUser($data, $id);
            $file = Input::file('profile_pic');

            if (!empty($file)) {

                $this->updateImageWeb($file, $user_detail, 'profile_pic');
            }
        } catch (\Exception $e) {
            DB::rollback();
            //  throw $e;
            Session::flash('message', \Config::get('constants.APP_ERROR'));
            // show the edit form and pass the contact
            self::edit($id);
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        // redirect
        Session::flash('message',  \Config::get('constants.USER_UPDATE'));
        return Redirect::to('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $users = User::where(['id' => $id])->first();
        $users->is_delete = User::IS_TRUE;
        $users->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request) {
        $request = $request->all();
        if (!empty($request)) {
            $id = $request['id'];
            $users = User::where(['id' => $id])->first();
            $users->is_active = !$request['value'];
            $users->save();
        }
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
        $templates = User::select(['id', 'email', 'first_name', 'last_name', 'dob', 'is_delete', 'is_active'])
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
    
    
     public function showLinkRequestForm($id)
    {
         $id= base64_decode($id);
         $users=User::find($id);
        return view('admin.resetpassword')->with(['users' =>$users]);
    }
    
    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postReset(Request $request) {
        $data=$request->all();    
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);
       
        $user = User::find($data['id']);
        if (empty($user)) {
            Session::flash('message', \Config::get('constants.USER_NOT_FOUND'));
            return redirect()->back();
        }
        $user->password = bcrypt($data['password']);
        $user->save();
       Session::flash('message',  \Config::get('constants.PASSWORD_CHANGE'));
       if($user->role=='user'){
        return Redirect::to('admin/users');
       }
        return Redirect::to('admin/vendors');
    }
    
     public function setting() {
    
        $settings = \App\Setting::find(1);

        // show the settings 
        return view('admin.setting')->with(['settings' => $settings]);
    }

}
