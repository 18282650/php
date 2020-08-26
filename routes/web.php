<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    Route::get('login','LoginController@login');
//验证码路由
    Route::get('code','LoginController@code');
//用户登录
    Route::post('doLogin','LoginController@doLogin');
});
//Route::get('admin/jiami','Admin\LoginController@jiami');
Route::get('/code/captcha/{tmp}', 'Admin\LoginController@captcha');
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function (){
//后台主页
    Route::get('index','LoginController@index');
//后台欢迎页面
    Route::get('welcome','LoginController@welcome');
//后台退出登录
    Route::get('logout','LoginController@logout');
    //后台用户相关路由
    Route::resource('user','UserController');
});

