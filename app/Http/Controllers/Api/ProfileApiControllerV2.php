<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\RequestException;

use Validator;
use GuzzleHttp;
use Carbon\Carbon;
use Hash;
use Auth;
use Session;
use DB;
use URL;

// Models
Use App\User;
Use App\Models\UserBankAccountDetail;
Use App\Models\UserCardsDetail;
Use App\Models\UserBookingRequest;
Use App\Models\PhotographerBookingReceiveList;

//Custom Class
Use App\Http\Controllers\StripeCustomClass;
Use App\Http\Controllers\PushNotificationCustomClass;

date_default_timezone_set('UTC');

class ProfileApiControllerV2 extends ResponseControllerV2
{
 	public function addCard(Request $request)
	{
		$user_id = Auth::User()->id;
		$validator = Validator::make($request->all(), [
			'card_number' => 'required',
			'stripe_card_id' => 'required'
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$user_data = Auth::User();
		// echo $user_data->UserCardsDetail()->count();
		if($user_data->UserCardsDetail()->count() > 0){
			$save_card = UserCardsDetail::where(['user_id' => $user_id])->first();
		}else{
			$save_card = new UserCardsDetail();
			$save_card->created_at = Date('Y-m-d H:i:s');
		}
		$save_card->card_number = $request->card_number;
		$save_card->stripe_card_id = $request->stripe_card_id;
		$save_card->updated_at = Date('Y-m-d H:i:s');
		$user_data->UserCardsDetail()->save($save_card);
		$check_card = $user_data->UserCardsDetail()->first();
		if(!empty($check_card)){
			return $this->responseOk('Card saved  successfully',$check_card);
		}else{
			return $this->responseWithError('Oops something went wrong.');
		}
	}

	public function checkAvailability(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'availability' => 'required|in:1,2',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$user_id = Auth::User()->id;
		$user_data = User::find($user_id);
		$user_data->availability = $request->availability;
		$user_data->updated_at = date('Y-m-d H:i:s');
		$user_data->save();
		return $this->responseOkWithoutData('Availability updated successfully');
	}
}
