<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
//api confirm
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Admin\Auth\RegisterController@confirm'
]);

Route::get('/confirm', function () {
    return view('confirm');
});
Route::get('password/reset/{verifytoken}', 'Api\v1\Auth\ResetPassswordController@reset');

Route::get('/password/reset/{token}/{email}', [
    'uses' => 'Api\v1\Auth\ResetPasswordController@showResetForm', 'as' => 'password.reset'
]);
Route::post('/password/reset', ['uses' => 'Api\v1\Auth\ResetPasswordController@postReset', 'as' => 'password.request']);


//frontend routes
Route::group(['namespace' => 'Frontend'], function () {
    //vendor confirm 
    Route::get('register/verifyvendor/{confirmationCode}', [
        'as' => 'confirmation_path_vendor',
        'uses' => 'Auth\LoginController@confirmvendor'
    ]);
//    Route::get('vendor/updatemembershipdate/','VendorController@updateMembershipDate');
    // vendor   register
    Route::get('/', 'Auth\LoginController@index')->name('vendormain');
    Route::get('/index', 'Auth\LoginController@vendorindex')->name('vendorindex');
    Route::get('/register', 'Auth\RegisterController@showCategoryForm')->name('frontend.register');
    Route::post('/register/create', 'Auth\RegisterController@create');
    Route::post('register/update', 'VendorController@update');
    Route::post('/register/subcription', 'Auth\RegisterController@subscribe');

    //vendor help pages

    Route::get('/terms_condition', 'Auth\LoginController@terms')->name('termscondition');
    Route::get('/privacy_policy', 'Auth\LoginController@privacy')->name('privacy');
    Route::get('/refund_policy', 'Auth\LoginController@refund')->name('refund');
    Route::get('/report', 'Auth\LoginController@report')->name('report');
    Route::get('/help', 'Auth\LoginController@help')->name('help');
    Route::get('/helpmobile', 'Auth\LoginController@helpmobile')->name('helpmobile');
    Route::get('/privacymobile', 'Auth\LoginController@privacymobile')->name('privacymobile');
    Route::get('/termsmobile', 'Auth\LoginController@termsmobile')->name('termsconditionmobile');
    Route::get('/aboutmobile', 'Auth\LoginController@aboutmobile')->name('aboutmobile');

    //vendor login
    Route::get('login', 'Auth\LoginController@vendorindex')->name('user.loginform');
    Route::post('vendor/login', 'Auth\LoginController@login')->name('vendor.login');
    Route::post('vendor/logout', 'Auth\LoginController@logout')->name('vendor.logout');
 

    //vendor update
    Route::post('vendor/updatePassword', 'Auth\ResetPasswordController@updatePasssword')->name('vendor.updatePassword');

    //vendor update card
    Route::post('vendor/editCreditCard', 'StripeController@editCreditCard')->name('vendor.editCreditCard');
//    Route::get('/vendor/deleteCard', 'StripeController@deleteCard')->name('vendor.cardDelete');
//    Route::get('/vendor/updateCard', 'StripeController@updateCard')->name('vendor.updateCard');
//    Route::get('/vendor/cancelSubscription', 'StripeController@cancelSubscription')->name('vendor.cancelSubscription');
//    Route::get('/vendor/updateSubscription', 'StripeController@updateSubscription')->name('vendor.updateSubscription');
//    Route::get('/vendor/changeSubscription', 'StripeController@changeSubscription')->name('vendor.changeSubscription');
    Route::get('/dashboard', 'HomeController@index')->name('frontend.main');
    Route::post('/user/forgetpassword', 'Auth\ResetPasswordController@postEmail');
    //coupon crud
    Route::delete('/coupon/{id}', 'CouponController@destroy');
    Route::get('/coupon/edit/{id}', 'CouponController@edit');
    Route::post('/coupon/update', 'CouponController@update')->name('front.coupon.update');
    Route::post('/coupon/store', 'CouponController@store');
    Route::post('/coupon/generateCouponCode', 'CouponController@generateCouponCode');
    Route::any('/vendor/changesubscription', array('as' => 'changesubscription', 'uses' => 'HomeController@changeSubscription'));
    Route::any('/vendor/cancelSubscription', array('as' => 'cancelsub', 'uses' => 'StripeController@cancelSubscription'));
    Route::post('/vendor/updatesubscription', 'StripeController@changeSubscription');

    // coupon dashboard
    Route::get('/vendor/dashboard', 'HomeController@dashboard');
    Route::post('/vendor/purchaseMiles', 'StripeAddOnsController@purchaseMiles');
    Route::post('/vendor/purchaseGeoFence', 'StripeAddOnsController@purchaseGeoFence');
    Route::post('/vendor/purchaseDeals', 'StripeAddOnsController@purchaseDeals');
    Route::post('/vendor/contact', 'HomeController@sendContact')->name('vendor.submitcontact');
    Route::post('/vendor/couponredeem', 'CouponController@CouponRedemption');
    
    Route::post('coupon/additonalcost', 'CouponController@additionalCost')->name('vendor.additionalcost');
});
// Admin routes
Route::group(['namespace' => 'Admin'], function () {
    Route::get('/admin/dashboard', 'HomeController@index')->name('home');
    Route::get('/admin', 'Auth\LoginController@showLoginForm');
    Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('admin.loginform');

    //user controller
    Route::get('admin/users/getlist', ['uses' => 'UserController@getlist', 'as' => 'datatables.userdata']);
    Route::get('admin/users/active', ['uses' => 'UserController@active']);
    Route::resource('admin/users', 'UserController');

    //setting
    Route::get('admin/settings', ['uses' => 'UserController@setting']);

    //vendor controller
    Route::get('admin/vendors/getlist', ['uses' => 'VendorController@getlist', 'as' => 'datatables.vendordata']);
    Route::get('admin/vendors/active', ['uses' => 'VendorController@active']);
    Route::resource('admin/vendors', 'VendorController');

    //login/logout
    Route::post('admin/login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('admin/logout', 'Auth\LoginController@logout');

    //password controller
    Route::patch('admin/password/reset', ['uses' => 'UserController@postReset', 'as' => 'admin.store']);
    Route::get('admin/password/reset/{id}', 'UserController@showLinkRequestForm');



    Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    //  Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('admin/register', 'Auth\RegisterController@register');
    Route::get('admin/home', 'HomeController@index');
    
    //admin panel userlist
    Route::get('admin/userlist', 'AdminController@userlist');
    Route::get('admin/user-detail/{id}', 'AdminController@userDetail');
    Route::get('admin/disable-user/{id}/{type}', 'AdminController@disableUser');
    Route::get('admin/active-user/{id}/{type}', 'AdminController@activeUser');
    Route::get('admin/offerlist-pdf/{id}', 'AdminController@offerlistPdf');
    
    Route::get('admin/vendorlist', 'AdminController@vendorlist');
    Route::get('admin/vendor-detail/{id}', 'AdminController@vendorDetail');
    Route::get('admin/business-detail-pdf/{id}', 'AdminController@businessDetailPdf');
    
    Route::get('admin/reported-content', 'AdminController@reportedContent');
    
    Route::get('admin/city', 'AdminController@citylist');
    Route::get('admin/payments', 'AdminController@payment');
});
