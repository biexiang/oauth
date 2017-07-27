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

/**
 * Apps
 */
//Apps Tao bao
Route::get('/index', 'Taobao\Pages@index');
Route::get('/user','Taobao\Pages@user');
//callback
Route::get('/callback/evil','Taobao\Callback@evil');


/**
 * Providers
 */
//Evil Corp
Route::get('/e/index','Providers\Evil@index');
//登录注册
Route::get('/e/login','Providers\Evil@login');
Route::get('/e/register','Providers\Evil@register');
Route::post('/e/register_handler','Providers\Evil@register_handler');
Route::post('/e/login_handler','Providers\Evil@login_handler');
//开发者获取Api key和Access_token
Route::get('/e/dev/info','Providers\Evil@get_info');
//Oauth登录
Route::get('/e/o/login','Providers\Evil@auth_login');
Route::post('/e/o/login_handler','Providers\Evil@auth_login_handler');
//获取token
Route::post('/e/o/get/token','Providers\Evil@push_token');
//获取user信息
Route::post('/e/o/get/user','Providers\Evil@get_user_by_token');







