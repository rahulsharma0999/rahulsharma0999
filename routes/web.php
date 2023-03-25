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

Route::get('/{index?}', function () {
    return view('front-pages/mainPage');
})->where("index","index");

Route::get('privacy-policy', function () {
    return view('front-pages/privacy-policy');
});
Route::get('terms-and-conditions', function () {
	
    return view('front-pages/terms-and-conditions');
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
/*Route::group(['prefix' => 'verify'],function(){
	
	Route::get('email/{token}', function($token){
		
		$token_user = User::where('email_verification_token',$token)->first();
		if(!empty($token_user)){
			$token_user->email_verification_token = '';
			$token_user->save();
			 Session::flash('success','Your email address verified successfully now you can login to your account.');
                return view('success');
		}else{
			return redirect(route('passwordResetInvalid'));
		}
	});

	Route::match(['get','post'],'password/{token}','HomeController@resetPassword');
});*/

Route::match(['Get','Post'],'verify/email/{token}','Api\ApiController@verify');
Route::match(['Get','Post'], 'reset-app-password/{reset_password_token}','Api\ApiController@resetPassword');
Route::match(['get','post'],'admin/login','Admin\HomeController@login');
Route::match(['get','post'],'admin/forgot-password','Admin\HomeController@forgotPassword'); 
Route::match(['Get','Post'],'admin/reset-password/{token}','Admin\HomeController@resetPassword');

Route::get('password-reset-success','Admin\HomeController@viewMessageResetPassword')->name('passwordReset');
Route::get('password-reset-invalid','Admin\HomeController@viewMessageResetPasswordInvalid')->name('passwordResetInvalid');

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
	Route::match(['get','post'],'review-detail/{request_id}','Admin\ReviewsManagementController@reviewDetail');
	                    //payment management
	Route::match(['get','post'],'payment-listing','Admin\PaymentManagementController@paymentListing');
	Route::match(['get','post'],'payment-detail/{id}','Admin\PaymentManagementController@paymentDetail');
	                    //service van management
	Route::match(['get','post'],'service-van-listing','Admin\ServiceVanManagementController@serviceVanListing');
	Route::match(['get','post'],'view-van-detail/{id}','Admin\ServiceVanManagementController@viewVanDetail');
	Route::match(['get','post'],'edit-van-detail/{id}','Admin\ServiceVanManagementController@editVanDetail');
	Route::match(['get','post'],'add-new-van','Admin\ServiceVanManagementController@addNewVan');
	Route::match(['get','post'],'delete-van','Admin\ServiceVanManagementController@deleteVan');

	Route::match(['get','post'],'vehicle-listing','Admin\VehicleTypeManagementController@VehicleListing');
	Route::match(['get','post'],'view-vehicle-detail/{id}','Admin\VehicleTypeManagementController@viewVehicleDetail');
	Route::match(['get','post'],'edit-vehicle-detail/{id}','Admin\VehicleTypeManagementController@editVehicleDetail');
	Route::match(['get','post'],'add-new-vehicle','Admin\VehicleTypeManagementController@addNewVehicle');
	
	//location tarcking
	Route::match(['get','post'],'location-tracking','Admin\LocationTrackingController@viewLocation');
	Route::match(['get','post'],'update-lat-lon/{id}','Admin\LocationTrackingController@updateLatLong');
	
	
	//Carpet service
	Route::match(['get','post'],'carpet-service','Admin\CarpetController@carpetService');
	Route::match(['get','post'],'carpet-measurement','Admin\CarpetController@carpetMeasurement');
	Route::match(['get','post'],'carpet-measurement-list','Admin\CarpetController@carpetMeasurementList');
	Route::match(['get','post'],'delete-carpet-measurement/{id}','Admin\CarpetController@deleteCarpetMeasurement');
	Route::match(['get','post'],'edit-carpet-measurement/{id}','Admin\CarpetController@editCarpetMeasurements');



	Route::match(['get','post'],'carpet-new-list','Admin\CarpetController@carpetNewList');
	Route::match(['get','post'],'carpet-past-list','Admin\CarpetController@carpetPastList');
	Route::match(['get','post'],'request-new-carpet-detail/{id}','Admin\CarpetController@requestNewCarpetDetail');
	Route::match(['get','post'],'request-past-carpet-detail/{id}','Admin\CarpetController@requestPastCarpetDetail');
	Route::match(['get','post'],'delete-new-carpet-request/{request_id}','Admin\CarpetController@deleteNewCarpetRequest');
	Route::match(['get','post'],'delete-past-carpet-request/{request_id}','Admin\CarpetController@deletePastCarpetRequest');
	Route::match(['get','post'],'accept-carpet-request','Admin\CarpetController@acceptCarpetRequest');
	Route::match(['get','post'],'carpet-payment-listing','Admin\CarpetController@carpetPaymentListing');
	Route::match(['get','post'],'carpet-payment-detail/{id}','Admin\CarpetController@carpetPaymentDetail');
	Route::match(['get','post'],'carpet-reviews','Admin\CarpetController@carpetReviewsListing');
	Route::match(['get','post'],'carpet-review-detail/{request_id}','Admin\CarpetController@carpetReviewDetail');



	//Upholstery service
	Route::match(['get','post'],'upholstery-service','Admin\UpholsteryController@upholsteryService');
	Route::match(['get','post'],'upholstery-couches','Admin\UpholsteryController@addUpholsteryCouches');
	Route::match(['get','post'],'upholstery-dinning-chair','Admin\UpholsteryController@addUpholsteryDinningChair');
	Route::match(['get','post'],'upholstery-side-chair','Admin\UpholsteryController@addUpholsterySideChair');

	Route::match(['get','post'],'delete-couches/{id}','Admin\UpholsteryController@deleteCouches');
	Route::match(['get','post'],'delete-dinning-chair/{id}','Admin\UpholsteryController@deleteDinningChair');
	Route::match(['get','post'],'delete-side-chair/{id}','Admin\UpholsteryController@deleteSideChair');

	Route::match(['get','post'],'upholstery-new-list','Admin\UpholsteryController@upholsteryNewList');
	Route::match(['get','post'],'upholstery-past-list','Admin\UpholsteryController@upholsteryPastList');
	Route::match(['get','post'],'request-new-upholstery-detail/{id}','Admin\UpholsteryController@requesNewUpholsteryDetail');
	Route::match(['get','post'],'request-past-upholstery-detail/{id}','Admin\UpholsteryController@requestPastUpholsteryDetail');

	Route::match(['get','post'],'delete-new-upholstery-request/{request_id}','Admin\UpholsteryController@deleteNewUpholsteryRequest');
	Route::match(['get','post'],'delete-past-upholstery-request/{request_id}','Admin\UpholsteryController@deletePastUpholsteryRequest');

	Route::match(['get','post'],'accept-upholstery-request','Admin\UpholsteryController@acceptUpholsteryRequest');

	Route::match(['get','post'],'upholstery-payment-listing','Admin\UpholsteryController@upholsteryPaymentListing');
	Route::match(['get','post'],'upholstery-payment-detail/{id}','Admin\UpholsteryController@upholsteryPaymentDetail');

	Route::match(['get','post'],'upholstery-reviews','Admin\UpholsteryController@upholsteryReviewsListing');
	Route::match(['get','post'],'upholstery-review-detail/{request_id}','Admin\UpholsteryController@upholsteryReviewDetail');


	Route::match(['get','post'],'add-advertisement','Admin\AdvertisementController@addAdvertisement');
	Route::match(['get','post'],'advertisement-listing','Admin\AdvertisementController@advertisementListing');
	Route::match(['get','post'],'edit-advertisement/{id}','Admin\AdvertisementController@editAdvertisement');
	Route::match(['get','post'],'delete-advertisement/{id}','Admin\AdvertisementController@deleteAdvertisement');



});  

Route::post('send-contact-us',"Admin\UserManagementController@sendContactUs");

/*Route::get("abc",function(){
	return storage_path('app/public');
});*/