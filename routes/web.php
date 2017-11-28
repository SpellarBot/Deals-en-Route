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
    // vendor   register
    Route::get('/', 'Auth\LoginController@index')->name('vendormain');
    Route::get('/register', 'Auth\RegisterController@showCategoryForm')->name('frontend.register');
    Route::post('/register/create', 'Auth\RegisterController@create');
    Route::post('register/update', 'VendorController@update');

    Route::post('/register/subcription', 'Auth\RegisterController@subscribe');

    //vendor login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('user.loginform');

    Route::post('vendor/login', 'Auth\LoginController@login')->name('vendor.login');
    Route::post('vendor/logout', 'Auth\LoginController@logout')->name('vendor.logout');

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
    
    // coupon dashboard
    Route::get('/vendor/dashboard', 'HomeController@dashboard');
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
});
