<?php

use App\User;
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

// Auth::routes();

Route::get('/', function () {
    return view('welcome');
    // return view('admin.dashboard');
});

Route::get('/clear', function() {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('view:clear');
	// $exitCode = Artisan::call('log:clear');
	
	// return what you want
    return 'cleared';
});

Route::get('pageNotFound404', function () {
    return view('pageNotFound404');
});

// verification Links
Route::group(['prefix' => 'verify'],function(){
	
	Route::get('email/{token}', function($token){
		
		$token_user = User::where('email_verification_token',$token)->first();
		if(!empty($token_user)){
			$token_user->email_verification_token = '';
			$token_user->save();
			return view('success',['msg' => 'Your account has been activated successfully. You can now login.']);
		}else{
			return view('pageNotFound404');
		}
	});

	Route::match(['get','post'],'password/{token}','HomeController@resetPassword');
});


Route::match(['get','post'],'admin/login','Admin\HomeController@login');
Route::match(['get','post'],'admin/forgot-password','Admin\HomeController@forgotPassword'); 
Route::match(['Get','Post'],'admin/reset-password/{token}','Admin\HomeController@resetPassword');


// 'middleware' => 'auth:web'
Route::group(['middleware'=>['auth'],'prefix'=>'admin'],function(){

	// Profile
	Route::get('dashboard', function(){
		return view('admin.dashboard');
	});
	
	Route::match(['Post','Get'],'change-password','Admin\HomeController@changePassword');
	Route::match(['Post','Get'],'log-out','Admin\HomeController@logout');
    

						//User Management
	Route::get('user-list','Admin\UserManagementController@usersList');
	Route::get('user-list1','Admin\UserManagementController@userListPagination')->name('users_data');
	//Route::get('admin/user-list-pagination','Admin\UserManagementController@userListPagination')->name('users_data');
	Route::match(['get'],'view-user-detail/{value}','Admin\UserManagementController@viewUserDetail');
	Route::match(['get'],'block-action-user/{value}','Admin\UserManagementController@blockUserAction');
	Route::match(['get','post'],'delete-user','Admin\UserManagementController@deleteUser');
	Route::match(['get','post'],'edit-user-detail/{value}','Admin\UserManagementController@editUserDetail');
	                    //service management
	Route::match(['get','post'],'service-listing','Admin\ServiceManagementController@serviceListing');
	Route::match(['get','post'],'edit-service/{id}','Admin\ServiceManagementController@editService');
	Route::match(['get','post'],'create-service','Admin\ServiceManagementController@createService');
	Route::match(['get','post'],'delete-service','Admin\ServiceManagementController@deleteService');
	                    //request management
	Route::match(['get','post'],'request-listing','Admin\RequestManagementController@requestListing');
	Route::match(['get','post'],'request-detail/{request_id}','Admin\RequestManagementController@requestDetail');
	Route::match(['get','post'],'accept-request','Admin\RequestManagementController@acceptRequest');
	Route::match(['get','post'],'delete-request/{request_id}','Admin\RequestManagementController@deleteRequest');
	Route::match(['get','post'],'past-requests','Admin\RequestManagementController@pastRequests');
	Route::match(['get','post'],'past-request-detail/{request_id}','Admin\RequestManagementController@pastRequestDetail');
	                    //review management
	Route::match(['get','post'],'reviews','Admin\ReviewsManagementController@reviewsListing');
	Route::match(['get','post'],'review-detail/{id}','Admin\ReviewsManagementController@reviewDetail');
	                    //payment management
	Route::match(['get','post'],'payment-listing','Admin\PaymentManagementController@paymentListing');
	Route::match(['get','post'],'payment-detail/{id}','Admin\PaymentManagementController@paymentDetail');
	                    //service van management
	Route::match(['get','post'],'service-van-listing','Admin\ServiceVanManagementController@serviceVanListing');
	Route::match(['get','post'],'view-van-detail/{id}','Admin\ServiceVanManagementController@viewVanDetail');
	Route::match(['get','post'],'edit-van-detail/{id}','Admin\ServiceVanManagementController@editVanDetail');
	Route::match(['get','post'],'add-new-van','Admin\ServiceVanManagementController@addNewVan');
	Route::match(['get','post'],'delete-van','Admin\ServiceVanManagementController@deleteVan');
	                    //location tarcking
	Route::match(['get','post'],'location-tracking','Admin\LocationTrackingController@viewLocation');
	Route::match(['get','post'],'update-lat-lon/{id}','Admin\LocationTrackingController@updateLatLong');
	
	
});  