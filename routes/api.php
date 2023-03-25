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
Route::group(['namespace' => 'Api'],function(){
	Route::post('register','ApiController@register');
	Route::post('login','ApiController@login');

	//Route::post('social-login','ApiController@socialLogin');
	Route::post('forgot-password','ApiController@forgotPassword');
	Route::match(['Get','Post'],'reset-password/{token}','ApiController@resetPassword');
	Route::match(['Get','Post'],'verify/{token}','ApiController@verify');
	Route::post('check-valid-email-or-phoneNumber','ApiController@checkValidEmailOrPhoneNumber');
	 Route::get("generate-pdf","ApiController@generatePdf");


Route::group(['middleware' => ['auth:api','check_block']],function(){
	  
	Route::post('add-vehicle','ApiController@addVehicle');
	Route::post('get-vehicle-list','ApiController@getVehicleList');
	Route::post('get-select-service- list','ApiController@getSelectServiceList');
	Route::post('get-vehicle-detail','ApiController@getVehicleDetail');
	Route::post('update-vehicle-detail','ApiController@updateVehicleDetail');
	Route::post('delete-vehicle','ApiController@deleteVehicle');
	Route::post('get-profile','ApiController@getProfile');
	Route::post('edit-profile','ApiController@editProfile');
	Route::post('service-request','ApiController@serviceRequest');
	Route::post('get-service-list','ApiController@getServiceList');
	Route::post('get-service-detail','ApiController@getServiceDetail');
	Route::post('change-password','ApiController@changePassword');
	Route::post('start-service','ApiController@startService');
	Route::post('get-notifications','ApiController@getNotifications');
	Route::post('get-vehicle-types','ApiController@getVehicleTypes');
	Route::post('add-crew','ApiController@addCrew');
	Route::post('delete-crew','ApiController@deleteCrew');
	Route::post('get-crew-list','ApiController@getCrewList');
	Route::post('log-out','ApiController@logOut');
	Route::post('update-lat-long','ApiController@updateLatLong');
	Route::post('complete-job','ApiController@completeJob');
    Route::post('add-rating','ApiController@addRating');
	Route::post('on-the-way','ApiController@onTheWay');
	Route::get('delete-notification-user','ApiController@deleteNotification');
    Route::post('invoice','ApiController@invoice');
    Route::post('payment','ApiController@payment');
    Route::post('confirm-payment','ApiController@confirm');
    Route::post('payment-invoice','ApiController@paymentInvoice');

    Route::GET('amount-per-square','ApiController@amountPerSquare');
    Route::GET('carpet-measurement-list','ApiController@carpetMeasurementList');

    // Route::Post('carpet-request','ApiController@carpetRequest');
   // Route::post('reject-payment','ApiController@reject');
    Route::GET('get-upholstery-price','ApiController@getUpholsteryprice');
    Route::GET('get-upholstery-item-list','ApiController@getUpholsteryItemList');

    // Route::GET('advertisement-list','ApiController@advertisementlist');



    
});

});
Route::any('test_api','ApiController@test_api');




//Version 2
Route::group(['namespace' => 'Api' , 'prefix' => 'v2'],function(){
	Route::post('register','ApiControllerV2@register');
	Route::post('login','ApiControllerV2@login');

	//Route::post('social-login','ApiControllerV2@socialLogin');
	Route::post('forgot-password','ApiControllerV2@forgotPassword');
	Route::match(['Get','Post'],'reset-password/{token}','ApiControllerV2@resetPassword');
	Route::match(['Get','Post'],'verify/{token}','ApiControllerV2@verify');
	Route::post('check-valid-email-or-phoneNumber','ApiControllerV2@checkValidEmailOrPhoneNumber');
	Route::get("generate-pdf","ApiControllerV2@generatePdf");

	Route::post("check-time","ApiControllerV2@checkTime");

	Route::group(['middleware' => ['auth:api','check_block']],function(){
		  
		Route::post('add-vehicle','ApiControllerV2@addVehicle');
		Route::post('get-vehicle-list','ApiControllerV2@getVehicleList');
		Route::post('get-select-service- list','ApiControllerV2@getSelectServiceList');
		Route::post('get-vehicle-detail','ApiControllerV2@getVehicleDetail');
		Route::post('update-vehicle-detail','ApiControllerV2@updateVehicleDetail');
		Route::post('delete-vehicle','ApiControllerV2@deleteVehicle');
		Route::post('get-profile','ApiControllerV2@getProfile');
		Route::post('edit-profile','ApiControllerV2@editProfile');
		Route::post('service-request','ApiControllerV2@serviceRequest');
		Route::post('get-service-list','ApiControllerV2@getServiceList');
		Route::post('get-service-detail','ApiControllerV2@getServiceDetail');
		Route::post('change-password','ApiControllerV2@changePassword');
		Route::post('start-service','ApiControllerV2@startService');
		Route::post('get-notifications','ApiControllerV2@getNotifications');
		Route::post('get-vehicle-types','ApiControllerV2@getVehicleTypes');
		Route::post('add-crew','ApiControllerV2@addCrew');
		Route::post('delete-crew','ApiControllerV2@deleteCrew');
		Route::post('get-crew-list','ApiControllerV2@getCrewList');
		Route::post('log-out','ApiControllerV2@logOut');
		Route::post('update-lat-long','ApiControllerV2@updateLatLong');
		Route::post('complete-job','ApiControllerV2@completeJob');
	    Route::post('add-rating','ApiControllerV2@addRating');
		Route::post('on-the-way','ApiControllerV2@onTheWay');
		Route::get('delete-notification-user','ApiControllerV2@deleteNotification');
	    Route::post('invoice','ApiControllerV2@invoice');
	    Route::post('payment','ApiControllerV2@payment');
	    Route::post('confirm-payment','ApiControllerV2@confirm');
	    Route::post('payment-invoice','ApiControllerV2@paymentInvoice');

	    Route::GET('amount-per-square','ApiControllerV2@amountPerSquare');
	    Route::GET('carpet-measurement-list','ApiControllerV2@carpetMeasurementList');

	    // Route::Post('carpet-request','ApiControllerV2@carpetRequest');
	   // Route::post('reject-payment','ApiControllerV2@reject');
	    Route::GET('get-upholstery-price','ApiControllerV2@getUpholsteryprice');
	    Route::GET('get-upholstery-item-list','ApiControllerV2@getUpholsteryItemList');

	    // Route::GET('advertisement-list','ApiControllerV2@advertisementlist');

	});

});
Route::any('test_api','ApiControllerV2@test_api');




Route::get('pageNotFound404',function(){
	return view('pageNotFound404');
});


// $get_service_requests->item_price = DB::table('upholstery_services')->first();

