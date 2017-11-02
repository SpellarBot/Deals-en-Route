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
    //vendor confirm 
     Route::get('register/verifyvendor/{confirmationCode}', [
        'as' => 'confirmation_path_vendor',
        'uses' => 'Admin\Auth\RegisterController@confirmvendor'
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
      
        // frontend home page register
        Route::get('/', 'Auth\LoginController@index');
        Route::get('/register', 'Auth\RegisterController@showCategoryForm')->name('frontend.register');
        Route::post('/register/create', 'Auth\RegisterController@create');
        Route::post('/register/subcription', 'Auth\RegisterController@subscribe');
        
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('user.loginform');
        Route::post('vendor/login', 'Auth\LoginController@login')->name('vendor.login');
        Route::post('vendor/logout', 'Auth\LoginController@logout');
       
        Route::get('/dashboard', 'HomeController@index')->name('vendorhome');

    
    });
    
   
    // Admin routes
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.loginform');

    //user controller
    Route::get('users/getlist', ['uses' => 'UserController@getlist', 'as' => 'datatables.userdata']);
    Route::get('users/active', ['uses' => 'UserController@active']);
    Route::resource('users', 'UserController');

    //setting
    Route::get('settings', ['uses' => 'UserController@setting']);

    //vendor controller
    Route::get('vendors/getlist', ['uses' => 'VendorController@getlist', 'as' => 'datatables.vendordata']);
    Route::get('vendors/active', ['uses' => 'VendorController@active']);
    Route::resource('vendors', 'VendorController');

    //login/logout
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout');

    //password controller
    Route::patch('password/reset', ['uses' => 'UserController@postReset', 'as' => 'admin.store']);
    Route::get('password/reset/{id}', 'UserController@showLinkRequestForm');



    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    //  Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('home', 'HomeController@index');
});
