<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Api Controller
Route::group(['Namespace' => 'Api'],function(){
	Route::post('register','ApiController@register');
	Route::post('login','ApiController@login');
	//Route::post('social-login','ApiController@socialLogin');
	Route::post('forgot-password','ApiController@forgotPassword');
	Route::match(['Get','Post'],'reset-password/{token}','ApiController@resetPassword');
	Route::match(['Get','Post'],'verify/{token}','ApiController@verify');
	Route::post('check-valid-email-or-phoneNumber','ApiController@checkValidEmailOrPhoneNumber');
});


Route::group(['middleware' => 'auth:api'],function(){
	
	Route::post('add-vehicle','ApiController@addVehicle');
	Route::post('get-vehicle-list','ApiController@getVehicleList');
	Route::post('get-select-service- list','ApiController@getSelectServiceList');
	Route::post('get-vehicle-detail','ApiController@getVehicleDetail');

	
});


Route::any('test_api','ApiController@test_api');
Route::get('pageNotFound404',function(){
	return view('pageNotFound404');
});