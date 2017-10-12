<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\User;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use Excel;
use URL;

class UserController extends Controller {

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
        $phonetype = Contact::phonetype();
        $emailtype = Contact::emailtype();
        $salutation = Contact::salutationtype();
        $countrycode = MasterCountry::getcountry();

        return view('contacts.create')->with(['phonetype' => $phonetype, 'countrycode' => $countrycode,
                    'emailtype' => $emailtype, 'salutation' => $salutation]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request) {

        // process the store
        $input = $request->all();
        $contact = Contact::create($input);
        $lastinsertedid = "RS" . $contact->recid;
        $caseId = ['case' => $lastinsertedid, 'cardcode' => $lastinsertedid, 'firmcode' => $lastinsertedid]; //put this value equal to datatable column name where it will be saved
        $contact->update($caseId);
        // redirect
        Session::flash('message', 'Contact created successfully ');
        return Redirect::to('contacts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $contact = Contact::editcontacts($id);
        $phonetype = Contact::phonetype();
        $emailtype = Contact::emailtype();
        $salutation = Contact::salutationtype();
        $countrycode = MasterCountry::getcountry();
        // show the edit form and pass the contact
        return view('contacts.edit')
                        ->with(['contact' => $contact, 'phonetype' => $phonetype, 'countrycode' => $countrycode,
                            'emailtype' => $emailtype, 'salutation' => $salutation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactFormRequest $contact, $id) {

        $request = $contact->all();
        $contacts = Contact::where(['cardcode' => $id])->first();

        if (!empty($contacts)) {
            $contacts->update($request);
        } else {
            $contact = Contact::create($request);
            $lastinsertedid = "RS" . $contact->recid;
            $caseId = ['case' => $lastinsertedid, 'cardcode' => $lastinsertedid, 'firmcode' => $lastinsertedid]; //put this value equal to datatable column name where it will be saved
            $contact->update($caseId);
        }
        // redirect
        Session::flash('message', 'Contact updated successfully!');
        return Redirect::to('contacts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $contacts = Contact::where(['cardcode' => $id])->first();
        $contacts->isdeleted = Contact::IS_DELETED;
        $contacts->save();
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
        $templates = User::select(['id', 'email', 'first_name', 'last_name', 'dob','is_delete','is_active']) 
                ->leftJoin('user_detail', 'user_detail.user_id', '=', 'users.id')
                ->active();
        $datatables = Datatables::of($templates)
               ->filterColumn('first_name', function ($query, $keyword) {
            $query->whereRaw("user_detail.first_name like ?", ["%$keyword%"]);
        })   ->filterColumn('last_name', function ($query, $keyword) {
            $query->whereRaw("user_detail.last_name like ?", ["%$keyword%"]);
        });

        // Global search function

        return $datatables->make(true);
    }

   

    public function importExportExcelORCSV() {
        return view('file_import_export');
    }

   
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

}