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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'user'], function () {
    // 註冊
    Route::post('register', 'UserController@registerUser');

    // 登入
    Route::post('login', 'LoginController@loginProcess');

});
