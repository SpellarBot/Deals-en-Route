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
//api
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Admin\Auth\RegisterController@confirm'
]);
Route::get('/confirm', function () {
    return view('confirm');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('password/reset/{verifytoken}', 'Api\v1\Auth\ResetPassswordController@reset');

Route::get('/password/reset/{token}/{email}', [
  'uses' => 'Api\v1\Auth\ResetPasswordController@showResetForm','as' => 'password.reset'
 ]);
Route::post('/password/reset', 
        ['uses' => 'Api\v1\Auth\ResetPasswordController@postReset','as'=>'password.request']);
Route::get('/home', 'HomeController@index')->name('home');


// admin routes
// Admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
   Route::get('/', function () {
    return view('admin.welcome');
});

    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
 
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('home', 'HomeController@index');

});

   //  Auth::routes();