<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use Storage;
use Auth;
use DateTime;
//date_default_timezone_set('Africa/Nairobi');
date_default_timezone_set("UTC");
use App\User;
use Mail;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\Controller;

class ResponseControllerV2 extends Controller
{
	
	public function is_require($data,$field)
	{
	   if(empty($data)){
		   $message = $field." field is required";
		   http_response_code(400);
		   // echo json_encode(['result'=>'Failure','message'=>$message]);exit;
		   echo json_encode(['return'=>0,'result'=>'Failure','message'=>$message]);exit;
	   }else{
		   return $data;
	   } 
	}
   
	public function responseOk($message,$data)
	{
		if(!empty($data)){
		   http_response_code(200);
		   // echo json_encode(['result'=>'Success','message'=>$message,'data'=>$data]);exit;
			echo json_encode(['return'=>1,'result'=>'Success','message'=>$message,'data'=>$data]);exit;
		}else{
			http_response_code(200);
		   // echo json_encode(['return'=>1,'result'=>'Success','message'=>$message]);exit;
			echo json_encode(['return'=>1,'result'=>'Success','message'=>$message]);exit;
		}
	}

	public function responseOkWithoutData($message)
	{
		http_response_code(204);
		return response()->json(['return'=>1,'result'=>'Success','message'=>$message]);
		exit;
	}
   
	public function responseWithError($message)
	{
		http_response_code(400);
		// echo json_encode(['result'=>'Failure','message'=>$message]);exit;
	    echo json_encode(['return'=>0,'result'=>'Failure','message'=>$message]);
	    exit;
    }
   
		
    public function checkUserExist()
	{
	   $userId = Auth::user()->id;
	 //  print $userId;die;
	   if(!empty($userId)){
		   $get_data = User::where('id',$userId)->first();
		   if(!empty($get_data)){
			   return $get_data;
		   }else{
			   http_response_code(401);
			   echo json_encode(['result'=>'Failure','message'=>'user does not exist']);exit;
		   }
		}else{
			http_response_code(401);
		   echo json_encode(['result'=>'Failure','message'=>'user does not exist']);exit;
		}
	}
								
   
	
	public static function randomNumber($length)
	{
		$result = '';
		for($i = 0; $i < $length; $i++) {
			$result .= mt_rand(0, 9);
		}
		return $result;
	}


	public function uploadImage($user_id,$image,$image_folder_name)
    {
        $image_name = str_random(20)."_$user_id.png";
        $path = Storage::putFileAs("public/$image_folder_name", $image, $image_name);
        $img_url =  "/storage/$image_folder_name/".$image_name;
        return $img_url;
    }

    public function copyImageFromLink($user_id,$image,$image_folder_name){
		$contents = file_get_contents($image);
		$image_name = str_random(20)."_new.png";
		Storage::put("public/user_image/$image_name", $contents);
		$image_url = "/storage/user_image/".$image_name;
		return $image_url;
    }

    public function sendMail($email_to,$mail_template,$subject,$data = array()){
	
    	try{
			Mail::send($mail_template,$data, function ($m) use ($data,$email_to,$subject) {
				$m->from(env('MAIL_FROM'), 'WaterWorks');
				$m->to($email_to,'App User');
				$m->cc('support@pw.co.ke','App User');
				$m->subject($subject);
			});
			return array('status' => 1, 'msg' => 'done');
		}catch(\Exception $e){
			return array('status' => 2,'msg' => 'Oops Something wrong! '.$e->getMessage());
		}
    }

     public function signupAccessToken($email,$password,$user_id){
    	
         $check_user_exist=User::where(['id'=>$user_id])->first();
    	try{
			$http = new GuzzleHttp\Client;
			$url = Url('oauth/token');
			$response = $http->post($url, [
						'form_params' => [
							'grant_type' => 'password',
							'client_id' => 2,
							'client_secret' =>'BgQ6Lfy8BCRn3Sg4W6IeIAmmJW5E3mMcqEbxGanL',
							'username' => $email,
							'password' => $password,
							'role' => 2,
							'scope' => '*',
						],
					]);
			 $return_data = json_decode($response->getBody(), true);
			if(!empty($return_data)){
				//return 'ggg';
				User::where(['id' => $user_id])->update(['refresh_token' =>$return_data['refresh_token']]);
				return array('status' => 1,'return_data'=>$return_data);
			}else{
				return array('status' => 2,'msg' => 'Oops Something wrong!');
			}
		}catch(\Exception $e){
			return array('status' => 2,'msg' => 'Oops Something wrong! '.$e->getMessage());
		}
	}

   public function refreshAccessToken($email,$password,$user_id){
    	
         $check_user_exist=User::where(['id'=>$user_id])->first();
    	try{
			$http = new GuzzleHttp\Client;
			$url = Url('oauth/token');
			$response = $http->post($url, [
						'form_params' => [
							'grant_type' => 'refresh_token',
							'refresh_token' => $check_user_exist->refresh_token,
							'client_id' => 2,
							'client_secret' =>'BgQ6Lfy8BCRn3Sg4W6IeIAmmJW5E3mMcqEbxGanL',
							'scope' => '*',
						],
					]);
			 $return_data = json_decode($response->getBody(), true);
			if(!empty($return_data)){
				
				$ttt=User::where(['id' => $user_id])->update(['refresh_token' =>$return_data['refresh_token']]);
				return array('status' => 1,'return_data'=>$return_data);
			}else{
				return array('status' => 2,'msg' => 'Oops Something wrong!');
			}
		}catch(\Exception $e){
			return array('status' => 2,'msg' => 'Oops Something wrong! '.$e->getMessage());
		}
	}
		
}
