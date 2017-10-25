<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\VendorRequest;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use URL;
use App\Http\Services\ImageTrait;

class VendorController extends Controller {

    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.vendor.index');
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
        return view('admin.vendor.create')->with(['categoryList' => $categoryList,
                    'show' => $show]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request) {
        DB::beginTransaction();
        try {
            // process the store
            $data = $request->all();

            $user_detail = \App\VendorDetail::createVendor($data);
            $file = Input::file('vendor_logo');
            //store image
            if (!empty($file)) {
                $this->addImageWeb($file, $user_detail, 'vendor_logo');
            }
        } catch (\Exception $e) {
            DB::rollback();
              // throw $e;
            Session::flash('message', \Config::get('constants.APP_ERROR'));
            return Redirect::to('admin/vendors');
        }
        // If we reach here, then// data is valid and working.//
        DB::commit();
        // redirect
        Session::flash('message', \Config::get('constants.VENDOR_CREATED'));
        return Redirect::to('admin/vendors');
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
                ->leftJoin('vendor_detail', 'vendor_detail.user_id', '=', 'users.id')
                ->where('users.id', $id)
                ->first();

        $imagePath = $this->showImage($users->vendor_logo, 'vendor_logo');
        $categoryList = \App\CouponCategory::categoryListWeb();

        // show the edit form and pass the contact
        return view('admin.vendor.edit')->with(['users' => $users, 'imagePath' => $imagePath,
                    'categoryList' => $categoryList, 'show' => $show]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id) {
           
        DB::beginTransaction();
        try {
            // process the store
            $data = $request->all();
            $user_detail = \App\VendorDetail::updateVendor($data, $id);
   
            $file = Input::file('vendor_logo');
            //store image
            if (!empty($file)) {
                $this->updateImageWeb($file, $user_detail, 'vendor_logo');
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
        Session::flash('message', \Config::get('constants.VENDOR_UPDATED'));
        return Redirect::to('admin/vendors');
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
        $templates = User::select(['id', 'email', 'vendor_phone', 'vendor_name', 'is_delete', 'is_active'])
                ->leftJoin('vendor_detail', 'vendor_detail.user_id', '=', 'users.id')
                ->where('role', '=', 'vendor')
                ->deleted();
        $datatables = Datatables::of($templates)->filterColumn('vendor_name', function ($query, $keyword) {
                            $query->whereRaw("vendor_detail.vendor_name like ?", ["%$keyword%"]);
                        })->filterColumn('vendor_phone', function ($query, $keyword) {
                            $query->whereRaw("vendor_detail.vendor_phone like ?", ["%$keyword%"]);
                        });

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
                ->leftJoin('vendor_detail', 'vendor_detail.user_id', '=', 'users.id')
                ->where('users.id', $id)
                ->first();
        $imagePath = $this->showImage($users->vendor_logo, 'vendor_logo');
        $categoryList = \App\CouponCategory::categoryListWeb();

        // show the edit form and pass the contact
        return view('admin.vendor.edit')->with(['users' => $users, 'imagePath' => $imagePath,
                    'categoryList' => $categoryList, 'show' => $show]);
    }

}
