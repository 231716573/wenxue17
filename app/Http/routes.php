<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'IndexController@index');

Route::group(['middleware' => ['web']], function () {
	// 生成验证码
	Route::get('admin/code', 'Admin\LoginController@code');
	// 用户登录
	Route::any('admin/login', 'Admin\LoginController@login');
	// 用户退出
	Route::any('admin/logout', 'Admin\LoginController@logout');
	// 用户注册
	Route::any('admin/register', 'Admin\LoginController@register');
});

Route::group(['middleware' => ['web', 'admin.login'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {

	// 后台管理员首页
	Route::get('/', 'IndexController@index'); 
	// 后台管理员首页
	Route::get('/index', 'IndexController@index');

	Route::get('/user', 'UserController@index');
	// 获取用户列表
	Route::get('/user/getUser', 'UserController@getUser');
	// 获取用户详细信息
	Route::get('/user/detail', 'UserController@detail');
	// 封号
	Route::get('/user/closure', 'UserController@closure');
	// 解封
	Route::get('/user/unlock', 'UserController@unlock');
	// 获取封号用户列表
	Route::get('/user/getClosure', 'UserController@getClosure');

	// 个人资料
	Route::get('/user/account', 'UserController@account');
	Route::post('/user/account', 'UserController@account');
	Route::get('/user/power', 'UserController@power');
	Route::post('/user/power', 'UserController@power');
	Route::get('/user/password', 'UserController@password');
	Route::post('/user/password', 'UserController@password');

	// 导航列表
	Route::get('/nav', 'NavController@index');
	Route::post('/nav', 'NavController@index');
	// 导航增删查改
	Route::post('/nav/add', 'NavController@add');
	Route::post('/nav/update', 'NavController@update');
	Route::get('/nav/openNav', 'NavController@openNav');
	Route::get('/nav/changeOrder', 'NavController@changeOrder');
	Route::get('/nav/delete', 'NavController@del');

	// 友情链接
	Route::get('/link', 'LinkController@index');
	Route::post('/link', 'LinkController@index');
	// 友情链接增删查改
	Route::post('/link/add', 'LinkController@add');
	Route::post('/link/update', 'LinkController@update');
	Route::get('/link/openLink', 'LinkController@openLink');
	Route::get('/link/changeOrder', 'LinkController@changeOrder');
	Route::get('/link/delete', 'LinkController@del');


	// 轮播图
	Route::get('/slider', 'SliderController@index');
	Route::post('/slider', 'SliderController@index');
	// 轮播图增删查改
	Route::post('/slider/add', 'SliderController@add');
	Route::post('/slider/update', 'SliderController@update');
	Route::get('/slider/openSlider', 'SliderController@openSlider');
	Route::get('/slider/changeOrder', 'SliderController@changeOrder');
	Route::get('/slider/delete', 'SliderController@del');


	// 分类
	Route::get('/cate', 'CateController@index');
	// 分类增删查改
	Route::post('/cate/add', 'CateController@add');
	Route::post('/cate/update', 'CateController@update');
	Route::get('/cate/openCate', 'CateController@openCate');
	Route::get('/cate/changeOrder', 'CateController@changeOrder');
	Route::get('/cate/delete', 'CateController@del');


	// 文章
	Route::get('/article', 'ArticleController@index');
});



Route::get('/', function () {
  return view('welcome');
});


