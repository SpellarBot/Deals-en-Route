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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// admin routes
// Admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
 
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('home', 'HomeController@index');

});
