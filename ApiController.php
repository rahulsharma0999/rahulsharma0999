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

//Custom Class
Use App\Http\Controllers\CustomClass\StripeCustomClass;
Use App\Http\Controllers\CustomClass\PushNotificationCustomClass;

date_default_timezone_set('UTC');
//date_default_timezone_set('Africa/Nairobi');

require_once __DIR__.'./../../pdf_format/autoload.inc.php';
use Dompdf\Dompdf;


class ApiController extends ResponseController
{
	public function __construct()
	{
		//timezone set
        //$ip = @$_SERVER['REMOTE_ADDR'];
        //$ipInfo = file_get_contents('http://ip-api.com/json/' . @$ip);
        //$ipInfo = json_decode($ipInfo);
//if($ipInfo->status == 'fail'){
//date_default_timezone_set('UTC');
       // }else{
            
          //  $timezone = $ipInfo->timezone;
          //  date_default_timezone_set($timezone);
      //  }
        //
    }
	
	#----------------------------------------Normal Signup --------------------------------------
	
	public function register(Request $request)
	{  
		$validator = Validator::make($request->all(),[						
				'email' => 'required',	
				'full_name' => 'required|max:50',						
				'phone_number' =>'nullable|digits_between:7,15',					
				'password' => 'required|max:15',
				'device_type' => 'nullable|in:ios,android',
				'device_token' => 'nullable',
				'latitude' => 'nullable',
				'longitude' => 'nullable',
				'role' => 'required|in:2,3', // (2=>user,3=>Van)
		]);		
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$check_email=DB::table('users')->where('email',$request->email)->first();
		if(!empty($check_email)){
			return $this->responseWithError('Email already registered');
		}

		$password = !empty($request->input('password')) ? $request->input('password'): "social_".$request->social_id;
		$insert_user = new User;
		$insert_user->email = $request->email;
		$insert_user->full_name=$request->full_name;
		$insert_user->phone_number= !empty($request->phone_number) ? $request->phone_number :'';
		$insert_user->password=Hash::make($password);
		$insert_user->visible_pwd = $password;
		$insert_user->reset_password_token = '';
		$insert_user->block_status = 1;  //  1=>unblock,2=>block	
		$insert_user->status = 1; // 2=>deleted
		$insert_user->latitude=!empty($request->input('lat')) ? $request->input('lat'):'';
		$insert_user->longitude=!empty($request->input('long')) ? $request->input('long'):'';
		$insert_user->role= $request->role;
		$insert_user->device_type = !empty($request->input('device_type')) ? $request->input('device_type'):'';
		$insert_user->device_token = !empty($request->input('device_token')) ? $request->input('device_token'):'';
		$insert_user->updated_at = Date('y-m-d H:i:s');
		$insert_user->created_at = Date('y-m-d H:i:s');
		$insert_user->save();

		$return_data = $this->signupAccessToken($request->email,$password,$insert_user->id);
		if(empty($return_data) || $return_data['status'] == 2){
			return $this->responseWithError('Oops Something wrong in token!');
		}
		$check_user = User::find($insert_user->id); 
		$token = encrypt($check_user->id);
		$check_user->email_verification_token = $token;
		$check_user->save();
		$url = url('verify/email/'.$token);
		// $url = url('verify/email/'.$email_verification_token);
            try{
                Mail::send('email_verify',['url' =>$url,'user_data' => $check_user], function ($m) use ($check_user) {
                    $m->from('support@pw.co.ke', 'PreshaWash');
                    $m->to($check_user->email,'App User');
                   
                    $m->subject('Email verification link');
                });
            }catch(\Exception $ex){
                 print $ex->getMessage();die;
                // $this->responseOk('Your account registration process has been completed Successfully','');
            }
		/*$mail_status = $this->sendMail($check_user->email,'email_verify','Verify Email address',$data = array('url' => $url, 'user_data' => $check_user));*/
		return $this->responseOkWithoutData('Your account has been registered successfully. Please verify your email address. If you don’t see a message in your inbox, make sure the email address you provided is correct and check your spam or junk mail folder.');
	}


	#----------------------------------------login --------------------------------------
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(),[				
			'email' => 'required|email|exists:users,email',	
			'password' => 'required',
			//'role' => 'required|in:2,3', // (2=>user,3=>Van)
			'latitude' => 'nullable',
			'longitude' => 'nullable',
			'device_type' => 'nullable|in:ios,android',
			'device_token' => 'nullable',
		]);		
		$device_token = !empty($request->device_token) ? $request->device_token:'';
		$device_type = !empty($request->device_type) ? $request->device_type:'';
		$lat = !empty($request->lat) ? $request->latitude:'';
		$long = !empty($request->long) ? $request->longitude:'';
		if ($validator->fails()) {
			return $this->responseWithError($validator->errors()->first());
		}

		$user_exist=User::where(['email' => $request->email])->first();

			if($user_exist->block_status == 2){
              return $this->responseWithError('Yor are blocked by admin');
			}
			if($user_exist->email_status != '2' && $user_exist->role == 2){
					$this->responseWithError('Please verify your account through the link sent to your registered email address.');
				}
        	
		$check_user_exist=User::where(function($query) use ($request){
				$query->where(['email' => $request->email,'block_status' =>1 , 'status' => 1]);
				$query->where('role',2);
			})
			->orWhere(function($query) use ($request){
				$query->where(['email' => $request->email,'block_status' =>1 , 'status' => 1]);
				$query->where('role',3);
			})
			->first();
       // print $check_user_exist;die;
		if(!empty($check_user_exist)){
			
			if(!Hash::check($request->password,$check_user_exist->password)){
				return $this->responseWithError('Please enter your valid email address or password');
			}
		}else{
			return $this->responseWithError('Please enter your valid email address or password');
		}
		

		if (!empty($check_user_exist)) {
			$return_data = $this->refreshAccessToken($request->email,$request->password,$check_user_exist->id);
			if(empty($return_data) || $return_data['status'] == 2){
				return $this->responseWithError('Oops Something wrong in token!');
			}else{
				$update_refresh_token = User::where(['id' =>$check_user_exist->id])->update(['refresh_token' =>$return_data['return_data']['refresh_token'],'device_type'=>$device_type, 'latitude' => $lat , 'longitude' => $long]);
				if ($request->device_token) {
					User::where('id', $check_user_exist->id)->update(['device_token'=>$device_token]);
				}
				$check_user_exist = User::where(['email' =>$request->email])->first();
				$check_user_exist->access_token = $return_data['return_data']['access_token'];
			}
			$this->responseOk('Login Successfully.',$check_user_exist);
		}else{
			return $this->responseWithError('Please enter your valid email address or password.');
		}
	}

    	public function verify(Request $request,$token)
    {
        $user_data = User::where(['email_verification_token' =>  $token])->first();
        if($user_data){
            if($token == $user_data->email_verification_token){
                $user_data = User::where(['email_verification_token' =>  $token])->update(['email_status'=>2, 'email_verification_token'=>null]);
                Session::flash('success','Your email address verified successfully now you can login to your account.');
                return view('success');
            } else {
                Session::flash('success','Email address already verified.');
                return view('success');
            }
        }else {
        	Session::flash('success','Email address already verified.');
                return view('success');
        }
    }

	public function checkValidEmailOrPhoneNumber(Request $request)
	{
		$validate = Validator::make($request->all(),[
			'email' => 'nullable|email|max:100',
			'phone_number' =>'nullable|digits_between:7,15'
		]);
		if($validate->fails()){
			return $this->responseWithError($validator->errors()->first());
		}

		if(!empty($request->email) && !empty($request->phone_number)){
			$check_email = User::where(['email' => $request->email])->first();
			$check_phone_number = User::where(['phone_number' => $request->phone_number])->first();
			if(!empty($check_email) && !empty($check_phone_number)){
				return $this->responseWithError('Email and phone number both are already taken.');
			}else if(!empty($check_email)){
				return $this->responseWithError('Email are already taken.');
			}else if(!empty($check_phone_number)){
				return $this->responseWithError('Phone Number are already taken.');
			}else{
				return $this->responseOkWithoutData('Email and phone number both are availabile.');
			}
		}else if(!empty($request->email)){
			$check_email = User::where(['email' => $request->email])->first();
			if(!empty($check_email)){
				return $this->responseWithError('Email are already taken.');
			}else{
				return $this->responseOkWithoutData('Email are availabile.');
			}
		}else if(!empty($request->phone_number)){
			$check_phone_number = User::where(['phone_number' => $request->phone_number])->first();
			if(!empty($check_phone_number)){
				return $this->responseWithError('Phone Number are already taken.');
			}else{
				return $this->responseOkWithoutData('Phone number are availabile.');
			}
		}else{
			return $this->responseWithError('Email and phone number parameters are required.');
		}
	}
	
	#--------------------------------------forgotPassword-----------------------------------------------------------
	public function forgotPassword1(Request $request)
	{
		$message_array = array('email.exists' => 'This email address does not register with us.');
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|exists:users,email',
		],$message_array);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$check_user_exist=User::where(function($query) use ($request){
			$query->where(['email' => $request->email,'block_status' =>1 , 'status' => 1]);
			$query->where('role',2);
		})
		->orWhere(function($query) use ($request){
			$query->where(['email' => $request->email,'block_status' =>1 , 'status' => 1]);
			$query->where('role',3);
		})->first();
		if(!empty($check_user_exist)){
			if($check_user_exist->status == 2){
				return $this->responseWithError('Please enter vaild email address.');
				exit;
			}
			$token = encrypt($check_user_exist->id);
			$check_user_exist->forgot_verification_token = $token;
			$check_user_exist->save();
			$url = url('verify/password/'.$token);
			 //$url = url('admin/reset-password/'.$token);
			 
			$mail_status = $this->sendMail($check_user_exist->email,'email_forget','Forgot Password Request',$data = array('url' => $url, 'user_data' => $check_user_exist));
			return $this->responseOkWithoutData('Forgot password link has been sent to your email address successfully.');
		}else{
			return $this->responseWithError('This email address does not register with us.');
		}
	}


 
	public function forgotPassword(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
			
		}
			$check_user_exist=User::where(function($query) use ($request){
			$query->where(['email' => $request->email,'block_status' =>1 , 'status' => 1]);
			$query->where('role',2);
		})
		->orWhere(function($query) use ($request){
			$query->where(['email' => $request->email,'block_status' =>1 , 'status' => 1]);
			$query->where('role',3);
		})->first();
		if(!empty($check_user_exist)){
			if($check_user_exist->status == 2){
				return $this->responseWithError('Please enter vaild email address.');
				exit;
			}
				$reset_password_token = str_random(40);
				/*$url = ('http://pw.co.ke/app/api/reset-app-password/'.$reset_password_token);*/
				$url = url('reset-app-password/'.$reset_password_token);
				$update_data = User::where('id',$check_user_exist->id)->update(['reset_password_token' => $reset_password_token, 'updated_at' => Date('Y-m-d H:i:s')]);
				try{
					$user_data = User::where('id',$check_user_exist->id)->first();
					$logo = url('admin/assets/img/logo-2.png');
					Mail::send('email_forget_app',['url' => $url,'user_data' => $user_data,'logo' => $logo], function ($m) use ($user_data) {
						$m->from(env('MAIL_FROM'), 'PreshaWash');
						$m->to($user_data->email,'App User');
						$m->subject('Forgot Password link');
					});
					$this->responseOk('success','Forgot password link has been sent to your registered email address.');
				}catch(\Exception $e){
					$this->responseWithError('Oops Something wrong! '.$e->getMessage());
				}
			
		}else{
			$this->responseWithError('This email address does not register with us');
		}
	}
	  public function viewMessageResetPassword()
    {
        // $link = url("/login");
        $title = "Password Reset Success";
        $message = "Password has been reset successfully.";
        $type = "success";
        return view('admin.feedback', compact('title', 'message', 'type','link'));
    }

    public function viewMessageResetPasswordInvalid()
    {
        $title = "Invalid link";
        $message = "The email link you clicked is invalid or has expired.";
        $type = "danger";
        return view('admin.feedback', compact('title', 'message', 'type'));
    }


      public function resetPassword(Request $request,$token){
		
       
        $check_token = DB::table('users')->where(['reset_password_token'=>$token])->first();
        if(!empty($check_token)){
            $current_time = Carbon::now();
            $startTime = Carbon::parse($current_time);
            $finishTime = Carbon::parse($check_token->updated_at);
            $difference= $finishTime->diffInMinutes($startTime); 
            if($difference > 9){
               return redirect(route('passwordResetInvalid'));
            }
            if($request->isMethod('post')){
                
				$message = [
    			'new_password.required' => 'Please enter new password.',
    			'confirm_password.required'	=> 'Please enter confirm password ',
				'confirm_password.same'=>'Confirm password doesnot match with new password'
    			
    		];
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password',
                ],$message);
                if($validator->fails()){
                    return redirect('app/api/reset-app-password/'.$token)->withErrors($validator)->withInput();
                }
                 //$login_token = Str::random(32);

                 $update_data = User::where('id',$check_token->id)->update(['password' => Hash::make($request->input('password')),'visible_pwd' => $request->input('password'), 'updated_at' => Date('Y-m-d H:i:s'),'reset_password_token' => '']);
                    Session::flash('success', 'Your Password has been changed Successfully.');
               return redirect(route('passwordReset'));
            }else{
                return view('admin.reset-password');
            }
            
        }else{
             return redirect(route('passwordResetInvalid'));
        }
    }
    
	#--------------------------------------addVehicle-----------------------------------------------------------
	public function addVehicle(Request $request)
	{
		
        $user_id=$this->checkUserExist();
       
		$validator = Validator::make($request->all(), [
			'vehicle_name' => 'required',
			'vehicle_type_id' => 'required|exists:vehicle_types,id',
			'vehicle_brand' =>'required',
			//'vehicle_model' =>'required',
			'vehicle_license_plate_no' =>'required',
			'vehicle_colour' =>'required',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$save_data['user_id']=$user_id->id;
		$save_data['name']=$request->vehicle_name;
		$save_data['brand']=$request->vehicle_brand;
		$get_vehicle_type=DB::table('vehicle_types')->where(['id'=>$request->vehicle_type_id])->first();
		$save_data['type']=$get_vehicle_type->type;
		$save_data['vehicle_type_id']=$request->vehicle_type_id;
		//$save_data['model']=$request->vehicle_model;
		$save_data['license_plate_no']=$request->vehicle_license_plate_no;
		$save_data['colour']=$request->vehicle_colour;
		$save_data['created_at']=Date('y-m-d H:i:s');
		$last_id=DB::table('vehicles')->insertGetId($save_data);
		$get_vehicle=DB::table('vehicles')->where('id',$last_id)->first();
		return $this->responseOk('Vehicle Addeded Successfully.',$get_vehicle);;
		
	}
    #--------------------------------------getVehicleList-----------------------------------------------------------
	public function getVehicleList(Request $request)
	{
		$user_id=$this->checkUserExist();
		
		$get_vehicles=DB::table('vehicles')->where(['user_id'=>$user_id->id])
				   	->select('created_at','updated_at','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour','id as vehicle_id','vehicle_type_id')
					 ->paginate('10');
		return $this->responseOk('Vehicle list',$get_vehicles);;
		
	}
    #--------------------------------------getSelectServiceList-----------------------------------------------------------
	public function getSelectServiceList(Request $request)
	{

		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
				'vehicle_type_id' => 'required|exists:vehicle_types,id',
		]);
		if($validator->fails()){

			return $this->responseWithError($validator->errors()->first());
		}
        
		$get_service=DB::table('services')->where(['vehicle_type_id'=>$request->vehicle_type_id])->first();
		if(empty($get_service)){
			return $this->responseWithError('No service found for this vehicle');
		}
		$add_on = DB::table('add_on_services')->get();
		$data = array(
			'main_service' =>	$get_service,
			'add_on_services'	=>	$add_on
		);
	
		return $this->responseOk('Select service list',$data);
		
	}

	public function getVehicleTypes(Request $request)
	{
		$user_id=$this->checkUserExist();
		$get_vehicle_types=DB::table('vehicle_types')->select('vehicle_types.id as vehicle_type_id','type','created_at','updated_at')->get();
		return $this->responseOk('vehicle type list',$get_vehicle_types);
		
	}
	#--------------------------------------getVehicleDetail-----------------------------------------------------------
	public function getVehicleDetail(Request $request)
	{
		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
				'vehicle_id' => 'required|exists:vehicles,id',

		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}  
        $get_vehicles=DB::table('vehicles')->where(['id'=>$request->vehicle_id])
        ->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour','created_at','updated_at')
        ->first();
		return $this->responseOk('Vehicle list',$get_vehicles);
		
		
		
	}
	#--------------------------------------updateVehicleDetail-----------------------------------------------------------
	public function updateVehicleDetail(Request $request)
	{
		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'vehicle_id' => 'required|exists:vehicles,id',
			'vehicle_name' => 'required',
			'vehicle_type' => 'required',
			'vehicle_brand' =>'required',
			//'vehicle_model' =>'required',
			'vehicle_license_plate_no' =>'required',
			'vehicle_colour' =>'required',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		
		$update_data['name']=$request->vehicle_name;
		$update_data['brand']=$request->vehicle_brand;
		$update_data['type']=$request->vehicle_type;
		//$update_data['model']=$request->vehicle_model;
		$update_data['license_plate_no']=$request->vehicle_license_plate_no;
		$update_data['colour']=$request->vehicle_colour;
		$update_data['updated_at']=Date('y-m-d H:i:s');

        $get_vehicles=DB::table('vehicles')->where(['id'=>$request->vehicle_id])->update($update_data);
		$get_vehicle=DB::table('vehicles')->where('id',$request->vehicle_id)
		->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour','created_at','updated_at')
		->first();
		return $this->responseOk('Vehicle detail updated successfully.',$get_vehicle);;
		
	}

	#--------------------------------------deleteVehicle-----------------------------------------------------------
	public function deleteVehicle(Request $request)
	{
		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
				'vehicle_id' => 'required|exists:vehicles,id',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$get_vehicle=DB::table('vehicles')->where('id',$request->vehicle_id)->delete();
		return $this->responseOk('Vehicle deleted successfully','');
		
	}
	
	#--------------------------------------editProfile-----------------------------------------------------------
	public function editProfile(Request $request)
	{
		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'full_name' => 'required',
		    'email' => 'required|email|unique:users,email,'.$user_id->id,
			'phone_number' => 'required',
			
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$update_data['full_name']=$request->full_name;
		$update_data['email']=$request->email;
		$update_data['phone_number']=$request->phone_number;
		$update_data['updated_at']=Date('y-m-d H:i:s');
        DB::table('users')->where(['id'=>$user_id->id])->update($update_data);
		$get_profile=DB::table('users')->where('id',$user_id->id)->first();
		return $this->responseOk('Profile updated successfully.',$get_profile);;
		
	}
	#--------------------------------------serviceRequest-----------------------------------------------------------
	public function changePassword(Request $request)
	{
		$user_data = $this->checkUserExist();
		$validator = Validator::make($request->all(), [
		    'old_password' => 'required',
			'new_password' => 'required',
			
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
			
		}
		if(Hash::check($request->input('old_password'),$user_data->password)){
			$update_data = User::where('id',$user_data->id)->update(['password' => Hash::make($request->input('new_password')),'visible_pwd' => $request->input('new_password'), 'updated_at' => Date('Y-m-d H:i:s')]);
			$this->responseOk('Password has been changed successfully.','');
		}else{
			$this->responseWithError('Old password does not match with your account.');
		}
		
	}

    #--------------------------------------serviceRequest-----------------------------------------------------------
	public function serviceRequest(Request $request)
	{
		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'vehicle_id' => 'required|exists:vehicles,id',
		    'service_id' => 'required|exists:services,id',
			'service_date' => 'required|date_format:Y-m-d',
			'service_time' => 'required|date_format:H:i',
			'service_address' => 'required',
			'add_on_service_id' => 'nullable',
			'lat' => 'required',
			'lng' => 'required',
			
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$save_data['user_id']=$user_id->id;
		$save_data['vehicle_id']=$request->vehicle_id;
		$save_data['service_id']=$request->service_id;
		$save_data['service_date']=$request->service_date;
		$save_data['service_time']=$request->service_time;
		$save_data['service_address']=$request->service_address;
		$save_data['lat']=$request->lat;
		$save_data['lng']=$request->lng;

		

		$get_main_price=DB::table('services')->where(['id'=>$request->service_id])->first();
        $add_on_price=array();
        $service_duration=array();
        $service_duration[]=$get_main_price->service_duration;

		if(!empty($request->add_on_service_id)){
			$explode=explode(',',$request->add_on_service_id);
			if(count($explode)>0){
				foreach ($explode as $key => $explod) {
					$get_add_amount=DB::table('add_on_services')->where(['id'=>$explod])->first();
                     $add_on_price[]=$get_add_amount->service_price;
                     $service_duration[]=$get_add_amount->service_duration;
				}
			}
		}
		/*return $service_duration;*/
		$total_price= $get_main_price->service_price + array_sum($add_on_price);
		$total_duration= $service_duration;

	     	$total_time=$this->addDurationTime($total_duration);
	
		$save_data['total_price']=$total_price;
		$save_data['service_duration']=$total_time;
		$save_data['service_end_time']=$total_time;


		$save_data['service_start_time']=$request->service_date.' '.$request->service_time;
		$service_duration[] = $request->service_time;

         $service_end_time = $this->addDurationTime($service_duration);
       	$time = $request->service_date.' '.$service_end_time;

       	$str_time = strtotime($request->service_date);
       	$add_time = 0;
       	$mins  = 0;
       if(strpos($service_end_time,":")){
       		$exp = explode(" ",$service_end_time)[0];
       		if(strpos($exp,":")){
       			$hour = (int)explode(":",$exp)[0];
       			$min = (int)explode(":",$exp)[1];
       			$mins =  $min * 60;
       			if($hour >= 23){
       				$sub_hour = $hour/23;
       				 $hours = explode(".",$sub_hour)[0];
       				$add_time = $hours * 86400;
       			}
       		}
       }

       $str_time = $str_time + $add_time + $mins;

		 /*$save_data['service_end_time'] = $request->service_date.' '.$service_end_time;*/

		$save_data['service_end_time'] = date("Y-m-d H:i",$str_time);

		$save_data['created_at'] = Date('y-m-d H:i:s');

        $last_id=DB::table('requests')->insertGetId($save_data);
        if(!empty($request->add_on_service_id)){
        	$add_on_ids=explode(',',$request->add_on_service_id);
        	foreach ($add_on_ids as $add_on_id) {
                $save_add_on['request_id']=$last_id;
                $save_add_on['user_id']=$user_id->id;
                $save_add_on['add_on_service_id']=$add_on_id;
                $save_add_on['created_at']=Date('y-m-d H:i:s');
        		DB::table('request_add_on_services')->insertGetId($save_add_on);
        	}
        }

		return $this->responseOk('Service request sent successfully.','');
		
	}
    #--------------------------------------addDurationTime-----------------------------------------------------------
	 
    function addDurationTime($times) {
	    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
	    // loop throught all the times
	    foreach ($times as $time) {
	        list($hour, $minute) = explode(':', $time);
	       
	        $minutes += $hour * 60;
	        $minutes += $minute;
	    }

	    $hours = floor($minutes / 60);
	    $minutes -= $hours * 60;
	    
	    // returns the time already formatted
	    return sprintf('%02d:%02d', $hours, $minutes);
	}

   #--------------------------------------getServiceList-----------------------------------------------------------

	 public function getServiceList_old(Request $request)
	{
		
		//$user_id=$this->checkUserExist();
		$user_id = $request->user_id ? User::find($request->user_id) : $this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'type' => ['required',Rule::in(['current', 'upcoming','past'])],
		  	'user_type' =>['required',Rule::in(['2', '3'])],
			
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		if ($request->device_token)
			$user = User::where('id', $user_id->id)->update(['device_token' => $request->device_token]);
		//$get_service_requests=DB::table('requests')->where(['user_id'=>$user_id->id])->get();
        $current_date=date('y-m-d');
        if($request->user_type ==2){
        if($request->type =='current' ){
       		 $get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.user_id'=>$user_id->id])
			->where(['requests.request_status'=>2])
           	->whereDate('service_date','=',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }elseif($request->type =='upcoming'){
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.user_id'=>$user_id->id])
			->where(['requests.request_status'=>2])
           	->whereDate('service_date','>',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }else{
			
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.user_id'=>$user_id->id])
			->where(['requests.request_status'=>2])
           	->whereDate('service_date','<',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }
    }else if($request->user_type ==3){
    	if($request->type =='current' ){
       		 $get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.van_id'=>$user_id->id])
           	->whereDate('service_date','=',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }elseif($request->type =='upcoming'){
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.van_id'=>$user_id->id])
           	->whereDate('service_date','>',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }else{
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.van_id'=>$user_id->id])
           	->whereDate('service_date','<',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }
    }

		return $this->responseOk('Booking list',$get_service_requests);;
		
	}


	 public function getServiceList(Request $request)
	{
		
		//$user_id=$this->checkUserExist();
		$user_id = $request->user_id ? User::find($request->user_id) : $this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'type' => ['required',Rule::in(['current', 'upcoming','past'])],
		  	'user_type' =>['required',Rule::in(['2', '3'])],
			
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		if ($request->device_token)
			$user = User::where('id', $user_id->id)->update(['device_token' => $request->device_token]);
		//$get_service_requests=DB::table('requests')->where(['user_id'=>$user_id->id])->get();
        $current_date=date('y-m-d');
        if($request->user_type ==2){
        if($request->type =='current' ){
       		 $get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.user_id'=>$user_id->id])
			->where(['requests.request_status'=>2])
			->where('requests.service_status','!=',3)
			//new chage this line 8-6-19- saturday--//
			//->where('requests.main_service_status','!=',3)
           	->whereDate('service_date','=',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }elseif($request->type =='upcoming'){
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.user_id'=>$user_id->id])
			->where(['requests.request_status'=>2])
			->where('requests.service_status','!=',3)
			//new chage this line 8-6-19- saturday--//
			//->where('requests.main_service_status','!=',3)
           	->whereDate('service_date','>',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }else{
			
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->leftJoin('request_add_on_services','request_add_on_services.request_id','=','requests.id')
           	->where(['requests.user_id'=>$user_id->id])
			->where(['requests.request_status'=>2])
			//->where('requests.main_service_status','=',3)
			->where('requests.service_status','=',3)
			->distinct('requests.id')
			->where('request_add_on_services.service_status','=',3)
           //	->whereDate('service_date','<',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }
    }else if($request->user_type ==3){
    	if($request->type =='current' ){
       		 $get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.van_id'=>$user_id->id])
           	->whereDate('service_date','=',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }elseif($request->type =='upcoming'){
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.van_id'=>$user_id->id])
           	->whereDate('service_date','>',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }else{
        	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.van_id'=>$user_id->id])
           	->whereDate('service_date','<',$current_date)
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->paginate('10');
        }
    }

		return $this->responseOk('Booking list',$get_service_requests);;
		
	}
	#--------------------------------------getServiceDetail-----------------------------------------------------------
	public function getServiceDetail(Request $request)
	{
		$user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'service_id' =>'required|exists:requests,id',
		  	'user_type' =>['required',Rule::in(['2', '3'])],
			
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
	    $get_service_requests=DB::table('requests')->where(['requests.id'=>$request->service_id])->select('service_duration as job duration','service_address as job_location_name','lat as job_location_lat','lng as job_location_lng','requests.service_date as job_date','requests.service_time as job_time','requests.service_address as job_address','requests.*')->first();

        $get_service_requests->main_service=DB::table('services')->where(['id'=>$get_service_requests->service_id])->first();  	
        $get_service_requests->main_service->service_status=$get_service_requests->main_service_status;
		$get_service_requests->user_detail=DB::table('users')->where(['id'=>$get_service_requests->user_id])->select('id','full_name','phone_number')->first();  	
        $get_service_requests->vehicle_detail=DB::table('vehicles')->where(['id'=>$get_service_requests->vehicle_id])
		->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour')
		->first();  	
        $get_service_requests->add_on_services=DB::table('request_add_on_services')
         									->leftJoin('add_on_services','add_on_services.id','=','request_add_on_services.add_on_service_id')			
        									->where(['request_add_on_services.request_id'=>$get_service_requests->id])
        									->select('request_add_on_services.*','add_on_services.*','request_add_on_services.id as add_on_service_id')
        									->get();  	

     	return $this->responseOk('Booking list',$get_service_requests);	
	}

    #--------------------------------------startService-----------------------------------------------------------
	public function startService(Request $request)
	{


		//timezone set
        //$ip = @$_SERVER['REMOTE_ADDR'];
       // $ipInfo = file_get_contents('http://ip-api.com/json/' . @$ip);
       // $ipInfo = json_decode($ipInfo);
       // if($ipInfo->status == 'fail'){
          //  date_default_timezone_set('UTC');
       // }else{
            
            //$timezone = $ipInfo->timezone;
          //  date_default_timezone_set($timezone);
       // }
        //

			//echo php_version();
			//return date("H:i:s");
        $user_id = $this->checkUserExist();
      	
		$validator = Validator::make($request->all(), [
			'service_type' =>['required',Rule::in(['1', '2'])],
			'request_type' => ['required',Rule::in(['1','2'])],
			//'service_id' =>'required|exists:requests,id',
			//'job_id' =>'required|exists:requests,id',
			
		]);

		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}

		$save_data['user_id'] = @$user_id->id;
     	$save_data['name'] = $request->job_id;
     	//service_type = 1,request_type : 1, service_id : 17
		if($request->service_type == '1'){
			$get_requset=DB::table('requests')->where(['id'=>$request->service_id])->first();

             $device_token  = DB::table('users')->where(['id'=>$get_requset->user_id])->first();

			$get_service = DB::table('services')->where(['id'=>$get_requset->service_id])->first();
			if($request->request_type == '1'){
				$update_data['main_service_status']=2;
				//$update_data['service_start_time']=Date('y-m-d H:i:s');
				/*$message='We have started on the '.$get_service->service_name." Invoice Number #".$get_requset->id;*/
				//4-12-19 $message = "The ".ucfirst($get_service->service_name)." is started.";
                  $message = "We have started on ".ucfirst($get_service->service_name).". ";
				$notfy_key=1;
				$notfy_message = array('sound' =>1,'message'=>$message,
		        'notifykey'=>'1');

			}else{
				
				$update_data['main_service_status']=3;
				//$update_data['service_end_time']=Date('y-m-d H:i:s');
				//$message= $get_service->service_name .' completed successfully.'." Invoice Number #".$get_requset->id;
				$message =  "The ".ucfirst($get_service->service_name) .' is now complete.';
				$notfy_key='2';
				$notfy_message = array('sound' =>1,'message'=>$message,
		        'notifykey'=>'2');
			}
			$notfy_message["service_id"] = $request->get("service_id");

			
			//$device_token='crfAjA3aQR4:APA91bEns3pN1ahHQ65Zf1VNU---mkdlmO_rWYwKf-h0mkmzL7xxh1vkNY1UyjNVKRve8cuVq50L09fc2ECXFUCyqazYcWB2AyGoxdIJhV4tv410oJB_87p7UblPU3V2cuJ4z_aL2zm9';
		   if($device_token->device_type == 'android'){
				$ddd = $this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
			}elseif(!empty($device_token->device_token  && $device_token->device_type == 'ios' && strlen($device_token->device_token) > 20 )){

				$ddd = $this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
			}
			
		    $save_notf['user_id']=$get_requset->user_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		    $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['created_at']=Carbon::now();
          
            DB::table('notifications')->insertGetId($save_notf);

             if($request->request_type == '1'){
            	$update_data["started_now"] = Carbon::now();
            }

			DB::table('requests')->where(['id'=>$request->service_id])->update($update_data);
			return $this->responseOk($message,'');
		} elseif($request->service_type == '2'){	
			$get_add_one_requset=DB::table('request_add_on_services')->where(['id'=>$request->service_id])->first();
			//print_r($get_add_one_requset);die();
			 $device_token  = DB::table('users')->where(['id'=>$get_add_one_requset->user_id])->first();
			//print_r($device_token);die();
			$get_service=DB::table('add_on_services')->where(['id'=>$get_add_one_requset->add_on_service_id])->first();
			if($request->request_type == '1'){
				$update_data['service_status']=2;
				//$message='We have started on '.$get_service->service_name.". Invoice Number #".$get_add_one_requset->id;
				$message = "We have started on ".ucfirst($get_service->service_name);
				//Main service:' .$get_service->service_name. 'started successfully.
				$notfy_key='1';
			}else{
				$update_data['service_status']=3;
				//$message= $get_service->service_name.' completed successfully.'." Invoice Number #".$get_add_one_requset->id;
				$message = ucfirst($get_service->service_name) .' is now complete.';
				$notfy_key='2';
			}
             $notfy_message = array('sound' =>1,'message'=> $get_service->service_name .'  completed successfully.',
		        'notifykey'=>'service_completed');
			//$device_token='crfAjA3aQR4:APA91bEns3pN1ahHQ65Zf1VNU---mkdlmO_rWYwKf-h0mkmzL7xxh1vkNY1UyjNVKRve8cuVq50L09fc2ECXFUCyqazYcWB2AyGoxdIJhV4tv410oJB_87p7UblPU3V2cuJ4z_aL2zm9';
		    
		   
		    if($device_token->device_type == 'android'){
				$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
			}elseif($device_token->device_type == 'ios'){
				$ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
			}
			$save_notf['user_id']=$get_add_one_requset->user_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		     $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['created_at']=Carbon::now();
            
            DB::table('notifications')->insertGetId($save_notf);
             if($request->request_type == '1'){
            	$update_data["started_now"] = Carbon::now();
            }

			DB::table('request_add_on_services')->where(['id'=>$request->service_id])->update($update_data);
			return $this->responseOk($message,'');
		}
	}


	public function getNotifications(Request $request)
	{
		/*change  11/07/2019*/
		 $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'user_type' =>['required',Rule::in(['2','3'])],
			
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		/*change  11/07/2019*/
		$is_van = false;
		if($user_id->role == '3'){
			$is_van = true;
		}

		 $get_notifications=DB::table('notifications');
		 $get_notifications = $get_notifications->where(['user_id'=>$user_id->id]);
		 if($is_van){
		 	$get_notifications = $get_notifications->where('notification','NOT LIKE','Van')->orderBy('id','DECS');
		 }
		 $get_notifications = $get_notifications->paginate(10);
		 //print_r($get_notifications);die();
		 return $this->responseOk($get_notifications,'');
	}


	public function addCrew(Request $request)
	{
		
		 $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'crew_name' =>'required',
		  	'phone_number' =>'required',
			
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$save_data['name']=$request->crew_name;
		$save_data['phone_number']=$request->phone_number;
		$save_data['service_van_id']=$user_id->id;
		$get_notificrew_namecations=DB::table('crew_members')->insertGetId($save_data);
		$get_crew_members=DB::table('crew_members')->where(['id'=>$get_notificrew_namecations])->select('crew_members.*','crew_members.name as crew_name')->first();
	     return $this->responseOk('Crew member added successfully.',$get_crew_members);
	}

	public function getCrewList(Request $request)
	{
		 
		 $user_id=$this->checkUserExist();
		
		 $get_crew_members=DB::table('crew_members')->where(['service_van_id'=>$user_id->id])->select('crew_members.*','crew_members.name as crew_name')->paginate(10);
		 return $this->responseOk('Crew member list',$get_crew_members);
	}

	public function deleteCrew(Request $request)
	{
		
		 $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'crew_id' =>'required|exists:crew_members,id',
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		
		 $get_notificrew_namecations=DB::table('crew_members')->where(['id'=>$request->crew_id])->delete();
		 return $this->responseOk('Crew member deleted successfully.','');
	}
	
	
	public function logOut(Request $request)
	{
		
		$user_id=$this->checkUserExist();

		DB::table('users')->where(['id'=>$user_id->id])->update(['device_token'=>'']);
		
		return $this->responseOk('Log out successfully.','');
	}
   

     public function updateLatLong(Request $request)
	{
		
		$user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	//'lat' =>'required',
		  	//'long' =>'required',
			
		]);
		
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$update_data['latitude']=$request->lat;
		$update_data['longitude']=$request->long;
		$update_refresh_token = User::where(['id' =>$user_id->id])->update($update_data);
		
		return $this->responseOk('lat long updated successfully.','');
	}


    public function completeJob (Request $request){

         $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'service_id' =>'required|exists:requests,id',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}

        $service_id = $request->input('service_id');

    	$get_request = DB::table('requests')->where(['id'=>$service_id])->first();

    	$serv_id = $service_id;

    	$get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();

    	$get_request_main = DB::table('request_add_on_services')->where(['request_id'=>$get_request->id])->get();
    	if(count($get_request_main) > 0 && !empty($get_request)){
    		foreach($get_request_main as $value){
    		$get_request_main->main_data = DB::table('request_add_on_services')->where(['request_id'=>$value->request_id])->first();
    	}

    	if($get_request->main_service_status == 3 && $get_request_main->main_data->service_status == 3){ 
    		$request_add_on_service  = DB::table('request_add_on_services')->where(['request_id'=>$get_request->id])->update(['service_status'=>3]);
       	$request_service  = DB::table('requests')->where(['id'=>$get_request->id])->update(['main_service_status'=>3,'service_status'=>3]);
       	$device_token  = DB::table('users')->where(['id'=>$get_request->user_id])->first();
		$notfy_key='5';
		$message = "Your PreshaWash is now complete. Please review the invoice and make a payment.";	
        $notfy_message = array('sound' =>1,'message'=>'Your PreshaWash is now complete. Please review the invoice and make a payment.',
		        'notifykey'=>'service_completed');
        $notfy_message['service_id'] = $serv_id;
        //$notfy_message;
	    if($device_token->device_type == "android"){
			$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
		}elseif($device_token->device_type == 'ios'){
			 $ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
		}

		   $save_notf['user_id']=$get_request->user_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		     $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['request_id']=$service_id;
		    $save_notf['created_at']=Date('y-m-d H:i:s');
            
            DB::table('notifications')->insertGetId($save_notf);
    	 return $this->responseOk('Your PreshaWash is now complete. Please review the invoice and make a payment.','');
    	}else{
    		$this->responseWithError('Please complete your service first.');
    	}
    	}else{
    	
    		if($get_request->main_service_status == 3 ){
    		
       	$request_service  = DB::table('requests')->where(['id'=>$get_request->id])->update(['main_service_status'=>3,'service_status'=>3]);
       	$device_token  = DB::table('users')->where(['id'=>$get_request->user_id])->first();
		$notfy_key='5';
		$message = "Your PreshaWash is now completed. Please review the invoice and make a payment.";	
        $notfy_message = array('sound' =>1,'message'=>'Your PreshaWash is now completed. Please review the invoice and make a payment.',
		        'notifykey'=>'service_completed');
        $notfy_message['service_id'] = $serv_id;
        //$notfy_message;
	    if($device_token->device_type == 'android'){
			$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
		}elseif($device_token->device_type == 'ios'){
			 $ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
		}

		   $save_notf['user_id']=$get_request->user_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		     $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['request_id']=$service_id;
		    $save_notf['created_at']=Date('y-m-d H:i:s');
            
            DB::table('notifications')->insertGetId($save_notf);
    	 return $this->responseOk('Your PreshaWash is now complete. Please review the invoice and make a payment.','');
    	}else{
    		$this->responseWithError('Please complete your service first.');
    	}
    	}
    	
       
       }
       
       public function payment(Request $request){
         $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'service_id' =>'required|exists:requests,id',
		  	'amount' =>'required',
		  	'van_id'=>'required',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
        $service_id = $request->input('service_id');
        $van_id = $request->input('van_id');

    	$get_request = DB::table('requests')->where(['id'=>$service_id])->first();
    	$get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
   
        $requested_user = User::find($get_request->user_id);
       	$device_token  = DB::table('users')->where(['id'=>$van_id])->first();
		$notfy_key='6';
		//$message = $requested_user->name.' Has made the payment for Invoice number #' .$service_id . '. Please confirm.';	
		$message = "Invoice number #".$service_id.". Has made a payment. Please confirm.";
        $notfy_message = array('sound' =>1,'message'=>$message,
		        'notifykey'=>'payment');
        $notfy_message['service_id'] = $service_id;
        //$notfy_message;
	    if($device_token->device_type == 'android'){
			$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
		}elseif($device_token->device_type == 'ios'){
			 $ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
		}
		   $save_notf['user_id']=$van_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		     $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['request_id']=$service_id;
		    $save_notf['created_at']=Date('y-m-d H:i:s');
            
            DB::table('notifications')->insert($save_notf);
             $amount = $request->input('amount');
             $service_id = $request->input('service_id');
            
            $payment_data = DB::table('payments')->insertGetId(['amount'=>$amount,'request_id'=>$service_id,'payment_status'=>1,'created_at'=>date('Y-m-d H:i:s'),'user_id'=>$user_id->id]);
            $get_payment = DB::table('payments')->where('id',$payment_data)->first();
    	  return $this->responseOk('please confirm the user payment of job.',$get_payment);
    	
       
       }

       public function confirm(Request $request){
         $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'service_id' =>'required|exists:requests,id',
		  	'payment_status'=>'required',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
        $service_id = $request->input('service_id');
        $payment_status = $request->input('payment_status');
    	$get_request = DB::table('requests')->where(['id'=>$service_id])->first();
    	$get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
   
   
       	$device_token  = DB::table('users')->where(['id'=>$get_request->user_id])->first();
		$notfy_key='7';
		if($payment_status ==2){

		$message = "Your payment is confirmed.";	
        $notfy_message = array('sound' =>1,'message'=>'Your payment is confirmed.',
		        'notifykey'=>'payment');
		}else{
		$message = "Your payment has been rejected.";	
        $notfy_message = array('sound' =>1,'message'=>'Your payment has been rejected.',
		        'notifykey'=>'payment');
		}
        $notfy_message['service_id'] = $service_id;
        $notfy_message['service_status'] = $payment_status;
        //$notfy_message;
	    if($device_token->device_type == 'android'){
			$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
		}elseif($device_token->device_type == 'ios'){
			 $ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
		}
		   $save_notf['user_id']=$get_request->user_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		     $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['request_id']=$service_id;
		    $save_notf['created_at']=Date('y-m-d H:i:s');
            
            DB::table('notifications')->insert($save_notf);
                 $service_id = $request->input('service_id');
                 $payment_status = $request->input('payment_status');
              if($payment_status == 2){  	
            $payment_data = DB::table('payments')->where(['request_id'=>$service_id])->update(['payment_status'=>2]);
              }else{
              	$payment_data = DB::table('payments')->where(['request_id'=>$service_id])->update(['payment_status'=>3]);
              }
              if($payment_status==2){

           $get_result = DB::table('payments')->where(['request_id'=>$service_id])->first();

           $get_service_requests=DB::table('requests')->where(['requests.id'=>$service_id])->select('service_duration as job duration','service_address as job_location_name','lat as job_location_lat','lng as job_location_lng','requests.service_date as job_date','requests.service_time as job_time','requests.service_address as job_address','requests.*')->first();

        $get_service_requests->main_service=DB::table('services')->where(['id'=>$get_service_requests->service_id])->first();  	
        $get_service_requests->main_service->service_status=$get_service_requests->main_service_status;
		$get_service_requests->user_detail=DB::table('users')->where(['id'=>$get_service_requests->user_id])->select('id','full_name','phone_number','email')->first();  	
        $get_service_requests->vehicle_detail=DB::table('vehicles')->where(['id'=>$get_service_requests->vehicle_id])
		->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour')
		->first();  
		
		$get_service_requests->payments = DB::table('payments')->where(['request_id'=>$service_id])->first();	
		
			$get_service_requests->payment_status = 2;
		    $get_service_requests->add_on_services=DB::table('request_add_on_services')
         									->leftJoin('add_on_services','add_on_services.id','=','request_add_on_services.add_on_service_id')			
        									->where(['request_add_on_services.request_id'=>$get_service_requests->id])
        									->select('request_add_on_services.*','add_on_services.*','request_add_on_services.id as add_on_service_id')
        									->get(); 

         $pdf = $this->generatePdf($get_service_requests);

         $url_name = explode("/",$pdf);
		 $file_name = array_pop($url_name);

		 $final_path = storage_path("app/public/generated_pdf").'/'.$file_name;
		 $data = [
			"user_data" => $get_service_requests->user_detail
		 ];
		 $user = $data["user_data"];
		if(isset($user->email) && !empty($user->email)){
      		try{
		      Mail::send("confirm_payment", $data, function($message) use($final_path,$file_name,$user){
		         $message->to($user->email, 'PreshaWash Receipt')->subject
		            ('PreshaWash Receipt');
		         $message->from('phpapiteam365@gmail.com','PreshaWash');
		         $message->attach($final_path, ["as"=>$file_name,"mime" => "application/pdf"]);
		      });	
      		}catch(Exception $ex){
      			print_r($ex->getMessage());
      		}
      	}

           // return $this->responseOk('Payment is confirmed.',$get_result);
            return response()->json(["return" => 1,"result" => "Success","message" => "Payment is confirmed",
    		"data" => $get_result,"pdf" => $pdf]);
              }else{
              	$get_result = DB::table('payments')->where(['request_id'=>$service_id])->first();
              	 return $this->responseOk('Payment is rejected.',$get_result);
              }
    	  
    	
       
       }
        /*public function reject(Request $request){
         $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'service_id' =>'required|exists:requests,id',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
        $service_id = $request->input('service_id');
    	$get_request = DB::table('requests')->where(['id'=>$service_id])->first();
    	$get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
   
   
       	$device_token  = DB::table('users')->where(['id'=>$get_request->user_id])->first();
		$notfy_key='6';
		$message = "Your paymnet is rejected";	
        $notfy_message = array('sound' =>1,'message'=>'Your payment is rejectd.',
		        'notifykey'=>'paymnet');
        $notfy_message['service_id'] = $service_id;
        //$notfy_message;
	    if($device_token->device_type == 'android'){
			$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
		}elseif($device_token->device_type == 'ios'){
			 $ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
		}
		   $save_notf['user_id']=$get_request->user_id;
		    $save_notf['notification']=$message;
		    $save_notf['notification_type']=$notfy_key;
		     $save_notf['service_name']=$get_service->service_name;
		    $save_notf['service_duration']=$get_service->service_duration;
		    $save_notf['request_id']=$service_id;
		    $save_notf['created_at']=Date('y-m-d H:i:s');
            
            DB::table('notifications')->insert($save_notf);
              $service_id = $request->input('service_id');
            $payment_data = DB::table('payments')->where(['request_id'=>$service_id])->update(['payment_status'=>3]);
            $get_result = DB::table('payments')->where(['request_id'=>$service_id])->first();
    	  return $this->responseOk('payment is rejected',$get_result);
    	
       
       }*/
        public function deleteNotification(Request $request)
	     {
		
		 $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	//'crew_id' =>'required|exists:users,id',
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		
		 $get_notificrew_namecations=DB::table('notifications')->where(['user_id'=>$user_id->id])->delete();
		 return $this->responseOk('user notification deleted successfully.','');
	}
	
   
    public function invoice(Request $request){
       $user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'service_id' =>'required|exists:requests,id',
		  	// 'user_type' =>['required',Rule::in(['2', '3'])],
			
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
	    $get_service_requests=DB::table('requests')->where(['requests.id'=>$request->service_id])->select('service_duration as job duration','service_address as job_location_name','lat as job_location_lat','lng as job_location_lng','requests.service_date as job_date','requests.service_time as job_time','requests.service_address as job_address','requests.*')->first();

        $get_service_requests->main_service=DB::table('services')->where(['id'=>$get_service_requests->service_id])->first();  	
        $get_service_requests->main_service->service_status=$get_service_requests->main_service_status;
		$get_service_requests->user_detail=DB::table('users')->where(['id'=>$get_service_requests->user_id])->select('id','full_name','phone_number','email')->first();  	
        $get_service_requests->vehicle_detail=DB::table('vehicles')->where(['id'=>$get_service_requests->vehicle_id])
		->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour')
		->first();  
		$get_service_requests->payments = DB::table('payments')->where(['request_id'=>$request->service_id])->first();	
		if(!empty($get_service_requests->payments)){
			$get_service_requests->payment_status = 1;
		}else{
			$get_service_requests->payment_status  = 0;
		}
        $get_service_requests->add_on_services=DB::table('request_add_on_services')
         									->leftJoin('add_on_services','add_on_services.id','=','request_add_on_services.add_on_service_id')			
        									->where(['request_add_on_services.request_id'=>$get_service_requests->id])
        									->select('request_add_on_services.*','add_on_services.*','request_add_on_services.id as add_on_service_id')
        									->get(); 
     	
        $pdf = $this->generatePdf($get_service_requests);

       $url_name = explode("/",$pdf);
		$file_name = array_pop($url_name);

		$final_path = storage_path("app/public/generated_pdf").'/'.$file_name;
		$data = [
			"user_data" => $get_service_requests->user_detail
		];
		$user = $data["user_data"];
		if(isset($user->email) && !empty($user->email)){
      		try{
		      Mail::send("invoice", $data, function($message) use($final_path,$file_name,$user){
		         $message->to($user->email, 'Payment Invoice')->subject
		            ('Payment Invoice');
		         $message->from('phpapiteam365@gmail.com','Payment Invoice');
		         $message->attach($final_path, ["as"=>$file_name,"mime" => "application/pdf"]);
		      });	
      		}catch(Exception $ex){
      			print_r($ex->getMessage());
      		}
      	}

        return response()->json([
        	 "return" => 1,
    		"result" => "Success",
    		"message" => "invoice list",
    		"data" => $get_service_requests,
    		"pdf" => $pdf
        ]);
	}
   

   public function paymentInvoice(Request $request){
       $user_id = $this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'service_id' =>'required|exists:requests,id',
		  	// 'user_type' =>['required',Rule::in(['2', '3'])],
			
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
	    $get_service_requests=DB::table('requests')->where(['requests.id'=>$request->service_id])->select('service_duration as job duration','service_address as job_location_name','lat as job_location_lat','lng as job_location_lng','requests.service_date as job_date','requests.service_time as job_time','requests.service_address as job_address','requests.*')->first();

        $get_service_requests->main_service=DB::table('services')->where(['id'=>$get_service_requests->service_id])->first();  	
        $get_service_requests->main_service->service_status=$get_service_requests->main_service_status;
		$get_service_requests->user_detail=DB::table('users')->where(['id'=>$get_service_requests->user_id])->select('id','full_name','phone_number','email')->first();  	
        $get_service_requests->vehicle_detail=DB::table('vehicles')->where(['id'=>$get_service_requests->vehicle_id])
		->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour')
		->first();  
		
		$get_service_requests->payments = DB::table('payments')->where(['request_id'=>$request->service_id])->first();	
		if(!empty($get_service_requests->payments)){
			$get_service_requests->payment_status = 1;
		}else{
			$get_service_requests->payment_status  = 0;
		}
        $get_service_requests->add_on_services=DB::table('request_add_on_services')
         									->leftJoin('add_on_services','add_on_services.id','=','request_add_on_services.add_on_service_id')			
        									->where(['request_add_on_services.request_id'=>$get_service_requests->id])
        									->select('request_add_on_services.*','add_on_services.*','request_add_on_services.id as add_on_service_id')
        									->get(); 
        $pdf = $this->generatePdf($get_service_requests);
        $url_name = explode("/",$pdf);
		$file_name = array_pop($url_name);
        $final_path = storage_path("app/public/generated_pdf").'/'.$file_name;
		$data = [
			"user_data" => $get_service_requests->user_detail
		];
		$user = $data["user_data"];
		//if(isset($user->email) && !empty($user->email)){
      		//try{
                //Mail::send("invoice", $data, function($message) use($final_path,$file_name,$user){
		         //$message->to($user->email, 'Payment Invoice')->subject
		            //('Payment Invoice');
		         //$message->from('phpapiteam365@gmail.com','Payment Invoice');
		        // $message->attach($final_path, ["as"=>$file_name,"mime" => "application/pdf"]);
		      //});	
      		//}catch(Exception $ex){
      			//print_r($ex->getMessage());
      		//}
      	//}

       return response()->json([
        	 "return" => 1,
    		"result" => "Success",
    		"message" => "invoice list",
    		"data" => $get_service_requests,
    		"pdf" => $pdf
        ]);

     	return $this->responseOk('invoice list',$get_service_requests);	
	}

	
	public function android($device_token,$message,$notmessage='',$sender_id='',$data_message = array()) 
	{/*
		print_r($sender_id); die;*/
	    #API access key from Google API's Console
	   //define('API_ACCESS_KEY', '');
/*
	  $API_ACCESS_KEY = 'AAAAf5RnkOU:APA91bFRItN-rIUjbk4XN9b9jED-LMVZWGjz8vaLfYcIyFwrMOXc_XafD3T9pT4AlstQrXLRTi_bRWwCX9COdV96LQiLO__tgfCDtUFezCgZsfbGbPYkkne2ifjHZXjGdfXCH6pVFWLB';*/
	  
	  $API_ACCESS_KEY = 'AAAA5Htr6lQ:APA91bGf4Cavz1trkLr34wPyzm83_4yDj-Y8szTB4WdJjwVMeVMiVo35ADB71HmGpBzmGnPUTNvSnYX9Dg0Gcghf0l6AQ6Q_0R8J_NUREswAIMp9MNye014cJr35djvjGyROeEzAPXHF';


		
	    $registrationIds = $device_token;
	    #prep the bundle
	     $msg = array( 
                'title' => "PreshaWash",
                'body'  => $message
	                // 'icon'   => 'default',/*Default Icon*/
	                //  'sound' => 'default',/*Default sound*/
	                //'data'    => $details
	     );


	     $details = array('Notifykey' => $notmessage, 
					'msgsender_id'=>$sender_id,
					'data_message' => $data_message,
					'service_id' => @$sender_id["service_id"]
					);

	    $fields = array(
            'to'=> $registrationIds,
            'notification'  => $msg,
            'data'  => ($details),
        );/*
	    echo json_encode($fields);die();


	    find_in_set($exp[$i])*/

	    $headers = array(
	                'Authorization: key=' . $API_ACCESS_KEY,
	                'Content-Type: application/json'
	            );
	    #Send Reponse To FireBase Server    
	    $ch = curl_init();
	    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	    curl_setopt( $ch,CURLOPT_POST, true );
	    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	    $result = curl_exec($ch );
	    curl_close( $ch );
	    #Echo Result Of FireBase Server
	    // echo $result;
	}
	 
	public function send_iphone_notification($receiver_id,$message,$notmessage='',$notfy_message)
    {  
    	//dd($data_message);
         // return $service_id;
          //  $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PEMFile.pem";
           // $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PushPem.pem";

          $PATH = dirname(dirname(dirname(dirname(__FILE__))))."/pemfile/PushCertificates.pem";

		//print $PATH;die;
            $deviceToken = $receiver_id;
            $passphrase = "";
            $message = $message;
			
            $ctx = stream_context_create();
                   stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
                   stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            
               // $fp = stream_socket_client(
               //                        'ssl://gateway.sandbox.push.apple.com:2195', $err,
               // $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
               
             $fp = stream_socket_client(
                                        'ssl://gateway.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
				 
			
				 
            $body['message'] = $message;
         	$body['service_id'] = $notfy_message;
         	$body['Notifykey'] = $notmessage;
         	//$body['service_id'] = $service_id;
			 
            if (!$fp)
                 exit("Failed to connect: $err $errstr" . PHP_EOL);

            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default',
                'details' => $body
            );
			
			//dd($body); die();
			
           

            $payload = json_encode($body);

            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));

            // echo "<pre>";
            // print_r($result);exit;
            
            // if (!$result)
                // echo 'Message not delivered' . PHP_EOL;
            // else
                // echo 'Message successfully delivered' . PHP_EOL;
            // exit;

            fclose($fp);
          	/*$PATH = base_path()."/pemfile/PushCertificates.pem";
          	
			//print $PATH;die;
            $deviceToken = $receiver_id;
            $passphrase = "";
            $message = $message;
			
            $ctx = stream_context_create();
                   stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
                   stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            
               $fp = stream_socket_client(
                                      'ssl://gateway.sandbox.push.apple.com:2195', $err,
               $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
               
             // $fp = stream_socket_client(
                                       //  'ssl://gateway.push.apple.com:2195', $err,
                // $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
				 
			
				 
            $body['message'] = $message;
         	$body['service_detail'] = $data_message;
         	$body['Notifykey'] = $notmessage;
         	//$body['ServiceDetail'] = $ServiceDetail;
			 
            if (!$fp)
                 exit("Failed to connect: $err $errstr" . PHP_EOL);

            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default',
                'details'=>$body
            );
			
			//dd($body);
			
           

            $payload = json_encode($body);
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));

            // echo "<pre>";
            print_r($result);exit;
            
            // if (!$result)
                // echo 'Message not delivered' . PHP_EOL;
            // else
                // echo 'Message successfully delivered' . PHP_EOL;
            // exit;
            fclose($fp);*/
			  
        } 

        #--------------------------------------getProfile-----------------------------------------------------------
	public function getProfile(Request $request)
	{
		$user_id=$this->checkUserExist();

		$validator = Validator::make($request->all(),[
				//'vehicle_id' => 'required|exists:vehicles,id',
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$get_profile=DB::table('users')->where('id',$user_id->id)->first();
		return $this->responseOk('get profile',$get_profile);
		
	}
	    public function addRating(Request $request){

		 $user_id=$this->checkUserExist();
		 $validator = Validator::make($request->all(),[
		  	'rating' =>'required',
		  	'request_id'=>'required',
		  	'review'=>'required'
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		$rating = $request->input('rating');
		$request_id = $request->input('request_id');
		$review = $request->input('review');
		$get_data = DB::table('reviews')->where(['user_id'=>$user_id->id,'request_id'=>$request_id])->first();
		if(!empty($get_data)){
			$this->responseWithError('You have already rated this service');
		}
		$result = DB::table('reviews')->insert(['user_id'=>$user_id->id,'request_id'=>$request_id,'rating'=>$rating,'review'=>$review,'created_at'=>date('Y-m-d H:i:s')]);
		//if(count($result)>0){
			$this->responseOk('Rating add successfully','');
		//}else{
			//$this->responseWithError('failed');
		//}
	}

	 public function onTheWay(Request $request){

	   $user_id = $this->checkUserExist();
      
		$validator = Validator::make($request->all(), [
			'request_id' =>'required'
		]);
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		}
		
		    $request_id = $request->input('request_id');
		   // $service_id = $request->input('service_id');
			$notfy_key = '7';
			$message = "Our awesome technicians are on the way to get you PreshaWashed.";
			  $notfy_message = array('sound' =>1,'message'=>'Our awesome technicians are on the way to get you PreshaWashed.',
		        'notifykey'=>'On the way');	
			$get_requset=DB::table('requests')->where(['id'=>$request->request_id])->first();
			//dd($get_requset);die;
             $device_token  = DB::table('users')->where(['id'=>$get_requset->user_id])->first();
             //dd($device_token);die;
             $get_service=DB::table('services')->where(['id'=>$get_requset->service_id])->first();

             /*change  11/07/2019*/

             if($device_token && !empty($device_token)){
             	if($device_token->role == '2' || $device_token->role == 2) {
			    if($device_token->device_type == 'android'){
					$ddd=$this->android($device_token->device_token,$message,$notfy_key,$notfy_message);
				}elseif($device_token->device_type == 'ios'){
					$ddd=$this->send_iphone_notification($device_token->device_token,$message,$notfy_key,$notfy_message);
				}
				
				$save_notf['user_id']=$device_token->id;
				$save_notf['request_id']=$device_token->id;
			    $save_notf['notification']=$message;
			    $save_notf['notification_type']=$notfy_key;
			    $save_notf['service_name']=$get_service->service_name;
			    $save_notf['service_duration']=$get_service->service_duration;
			    $save_notf['created_at']=Date('y-m-d H:i:s');
	            DB::table('notifications')->insertGetId($save_notf);
				DB::table('requests')->where(['id'=>$get_requset->id])->update(['on_the_way_status'=>1]);
			}
		
		}
			return $this->responseOk($message,'');
		
		}

		private function generatePdf($data){
			$dompdf = new Dompdf();
			$name = @$data->user_detail->full_name."".time();
				$invoice_num = $data->id;
				$invoice_date = $due_date = date("M d, Y");
				//$sub_total_amount = "USD".(10);
				//$credit_amount = "USD".(10);
				$total_amount = $data->main_service->service_price;


				$user_address = '<p style="font-size: 19px;color: #000;text-decoration:none;">'.$data->user_detail->full_name.'</p><p style="font-size: 19px;color: #000;text-decoration:none;">'.$data->user_detail->phone_number.'</p>';


			     $vehicle_detail = '<p style="font-size: 19px;color: #000;text-decoration:none;padding:0; margin:0;"><strong>Vehicle Name</strong><span>: '.$data->vehicle_detail->vehicle_name.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none; padding:0; margin:0;"><strong>Vehicle Brand</strong><span>: '.$data->vehicle_detail->vehicle_brand.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none; padding:0; margin:0;"><strong>Vehicle Color</strong><span>: '.$data->vehicle_detail->vehicle_colour.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none; padding:0; margin:0;"><strong>Vehicle Type</strong><span>: '.$data->vehicle_detail->vehicle_type.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none;padding:0; margin:0;"><strong>Vehicle License Plate Number</strong><span>: '.$data->vehicle_detail->vehicle_license_plate_no.'</span></p>';
				
				$main_service = '<td width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">'.$data->main_service->service_name.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">'.$data->main_service->service_duration.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">KSH '.$data->main_service->service_price.'</td>';

			     $added_service_data = "";
			    
			     $pay_image = "unpaid.png";
			     if(!empty($data->payments)){
	                if($data->payments->payment_status == "2"){
	                	$pay_image = "paid.png";
	                }
			     }
			     if(!empty($data->add_on_services) && count($data->add_on_services) > 0){
			     	foreach ($data->add_on_services as  $value) {
			     		if($value->service_price && $value->service_name && $value->service_duration){


			     		$total_amount += $value->service_price; 
			     		$added_service_data .= '<tr>
			                                            <td width="20" style="border: 1px solid #eeeeee;text-align: center;">'.$value->service_name.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">'.$value->service_duration.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee;text-align: center;">KSH '.$value->service_price.'</td></tr>';
			            }
			     	}
			     }
			     $added_service = '<table border="0" cellspacing="0" cellpadding="0" style="padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
			                                    <thead>
			                                        <tr style="background-color: #ccc;">
			                                            <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">Add On Services</th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align: center;">Duration</th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align: center;">Cost</th>
			                                        </tr>
			                                    </thead>
			                                    <tbody>
			                                       '.$added_service_data.'
			                                    </tbody>
			                                </table>';

				$put_data = '<div style="background:#fff;border: 10px solid #ccc;">
			    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			        <tr>
			            <td width="20" align="left" valign="top">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                    <tr>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                        <td align="left" valign="top">
			                            <a href="#" style="border:0; outline:0;">
			                                <img src="'.public_path("pdf_assets/logo.png").'" alt="" width="120" style="margin-top:3px;" /></a>
			                        </td>
			                        <td width="20" align="left" valign="top">
			                            <img src="'.public_path("pdf_assets/".$pay_image."").'" alt="" width="120" />
			                        </td>
			                    </tr>
			                </table>
			            </td>
			        </tr>
			        <tr>
			            <td width="20" align="left" valign="top">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                    <tr>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                        <td align="right" valign="top" style="padding:0;">
			                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:0;margin-bottom:5px;">PreshaWash</p>
			                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:0;margin-bottom:3px;">0708420165</p>
			                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:0;margin-bottom:5px;">pw.co.ke</p>
			                            
			                        </td>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                    </tr>
			                </table>
			            </td>
			        </tr>
			        <tr style="height:5px;"><td>&nbsp;</td></tr>
			        <tr>
			            <td width="20" align="left" valign="top">
			                <table width="auto" border="0" cellspacing="0" cellpadding="0" style="background-color: #74BF4C; color: #fff; padding: 12px 9px;width:100%">
			                    <tr>
			                        <td align="left" valign="top" width="200">
			                            <h2 style="font-size: 24px; color: #fff; text-decoration:none; margin:0;">Invoice #'.$invoice_num.'</h2></td>
			                        <td align="left" valign="top" style="padding:10px 0; ">

			                        </td>
			                    </tr>
			                    <tr>
			                        <td width="100" style="">
			                            <label>Invoice Date: '.$invoice_date.'</label>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td style="">
			                            <label>Due Date: '.$due_date.'</label>
			                        </td>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                </table>
			            </td>
			            </tr>
			            <tr>
			                <td width="20" align="right" valign="top">
			                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			                        <tr>
			                            <td width="20" align="right" valign="top">&nbsp;</td>
			                            <td align="left" valign="top" style="padding:10px 0;">
			                                <h2 style="font-size: 19px;color: #01cdfe;text-decoration:none;">Invoice To</h2>
			                                	'.$user_address.'
			                                
			                            </td>
			                            <td align="left" valign="top" style="padding:10px 0;">
			                                <h2 style="font-size: 19px;color: #01cdfe;text-decoration:none;">Vehicle details</h2>
			                                	'.$vehicle_detail.'
			                            </td>
			                            <td width="20" align="left" valign="top">&nbsp;</td>
			                        </tr>
			                    </table>
			                </td>
			            </tr>

			            <tr>
			                <td width="20" align="left" valign="top">
			                    <table border="0" cellspacing="0" cellpadding="0" style="background-color: #74BF4C;padding: 12px 9px;width:100%">
			                        <tr>
			                            <td align="left" valign="top" width="200">
			                                <h2 style="font-size: 24px;color: #fff;text-decoration:none; margin:0;">Service Packages</h2></td>
			                            <td align="left" valign="top" style="padding:10px 0; ">

			                            </td>
			                        </tr>

			                    </table>
			                </td>
			            </tr>
			            <tr>
			                <td width="20" align="right" valign="top">
			                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			                        <tr>
			                            <td align="left" valign="top" style="padding:10px 0;width:50%">
			                                <table border="0" cellspacing="0" cellpadding="0" style="    padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
			                                    <thead>
			                                        <tr style="background-color: #ccc;">
			                                            <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0;text-align:center;">Main Service</th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align:center;">Duration </th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align:center;">Cost </th>

			                                        </tr>
			                                    </thead>
			                                    <tbody>
			                                        <tr>
			                                            '.$main_service.'

			                                        </tr>
			                                    </tbody>
			                                </table>

			                            </td>
			                            <td align="right" valign="top" style="padding:10px 0;width:50%">
			                                '.$added_service.'
			                            </td>
			                        </tr>
			                    </table>
			                </td>
			            </tr>

			            <tr>
			                <td width="20" align="right" valign="top">
			                    <table border="0" cellspacing="0" cellpadding="0" style="padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
			                        <tbody>
			                            <tr style="background-color: #ccc;">
			                                <td width="20" align="right" style="border: 1px solid #eeeeee; padding: 10px 6px;"><strong>Total</strong></td>
			                                <td width="20" style="border: 1px solid #eeeeee; text-align: center;"><strong>KSH '.$total_amount.'</strong></td>

			                            </tr>
			                        </tbody>

			            </tr>
			            </table>
			</div>';
			//echo $put_data; die;
				$dompdf->loadHtml($put_data);
				$dompdf->setPaper('A3', 'portrat');
				 $dompdf->render();

				$final = $dompdf->output();
				$path = "app/public/generated_pdf/".$name.'.pdf';
				$file = storage_path($path);
				 file_put_contents(storage_path("app/public/generated_pdf/".$name.'.pdf'), $final);
				 $url = url("/");
				 $url_name = explode("/",url("/"));
				array_pop($url_name);
				$final = implode("/",$url_name);

				 return $final."/storage/".$path;
		}


		/*private function generatePdfConfirm($data){
			$dompdf = new Dompdf();
			$name = @$data->user_detail->full_name."".time();
				$invoice_num = $data->id;
				$invoice_date = $due_date = date("M d, Y");
				//$sub_total_amount = "USD".(10);
				//$credit_amount = "USD".(10);
				$total_amount = $data->main_service->service_price;


				$user_address = '<p style="font-size: 19px;color: #000;text-decoration:none;">'.$data->user_detail->full_name.'</p><p style="font-size: 19px;color: #000;text-decoration:none;">'.$data->user_detail->phone_number.'</p>';


			     $vehicle_detail = '<p style="font-size: 19px;color: #000;text-decoration:none;padding:0; margin:0;"><strong>Vehicle Name</strong><span>: '.$data->vehicle_detail->vehicle_name.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none; padding:0; margin:0;"><strong>Vehicle Brand</strong><span>: '.$data->vehicle_detail->vehicle_brand.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none; padding:0; margin:0;"><strong>Vehicle Color</strong><span>: '.$data->vehicle_detail->vehicle_colour.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none; padding:0; margin:0;"><strong>Vehicle Type</strong><span>: '.$data->vehicle_detail->vehicle_type.'</span></p>
			                                <p style="font-size: 19px;color: #000;text-decoration:none;padding:0; margin:0;"><strong>Vehicle License Plate Number</strong><span>: '.$data->vehicle_detail->vehicle_license_plate_no.'</span></p>';
				
				$main_service = '<td width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">'.$data->main_service->service_name.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">'.$data->main_service->service_duration.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">KSH '.$data->main_service->service_price.'</td>';

			     $added_service_data = "";

			     if(!empty($data->add_on_services) && count($data->add_on_services) > 0){
			     	foreach ($data->add_on_services as  $value) {
			     		if($value->service_price && $value->service_name && $value->service_duration){


			     		$total_amount += $value->service_price; 
			     		$added_service_data .= '<tr>
			                                            <td width="20" style="border: 1px solid #eeeeee;text-align: center;">'.$value->service_name.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">'.$value->service_duration.'</td>
			                                            <td width="20" style="border: 1px solid #eeeeee;text-align: center;">KSH '.$value->service_price.'</td></tr>';
			            }
			     	}
			     }
			     $added_service = '<table border="0" cellspacing="0" cellpadding="0" style="padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
			                                    <thead>
			                                        <tr style="background-color: #ccc;">
			                                            <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">Add On Services</th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align: center;">Duration</th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align: center;">Cost</th>
			                                        </tr>
			                                    </thead>
			                                    <tbody>
			                                       '.$added_service_data.'
			                                    </tbody>
			                                </table>';

				$put_data = '<div style="background:#fff;border: 10px solid #ccc;">
			    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			        <tr>
			            <td width="20" align="left" valign="top">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                    <tr>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                        <td align="left" valign="top">
			                            <a href="#" style="border:0; outline:0;">
			                                <img src="'.public_path("pdf_assets/logo.png").'" alt="" width="120" style="margin-top:3px;" /></a>
			                        </td>
			                        <td width="20" align="left" valign="top">
			                            <img src="'.public_path("pdf_assets/paid.png").'" alt="" width="120" />
			                        </td>
			                    </tr>
			                </table>
			            </td>
			        </tr>
			        <tr>
			            <td width="20" align="left" valign="top">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                    <tr>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                        <td align="right" valign="top" style="padding:0;">
			                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:0;margin-bottom:5px;">PreshaWash</p>
			                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:0;margin-bottom:3px;">0708420165</p>
			                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:0;margin-bottom:5px;">pw.co.ke</p>
			                            
			                        </td>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                    </tr>
			                </table>
			            </td>
			        </tr>
			        <tr style="height:5px;"><td>&nbsp;</td></tr>
			        <tr>
			            <td width="20" align="left" valign="top">
			                <table width="auto" border="0" cellspacing="0" cellpadding="0" style="background-color: #74BF4C; color: #fff; padding: 12px 9px;width:100%">
			                    <tr>
			                        <td align="left" valign="top" width="200">
			                            <h2 style="font-size: 24px; color: #fff; text-decoration:none; margin:0;">Invoice #'.$invoice_num.'</h2></td>
			                        <td align="left" valign="top" style="padding:10px 0; ">

			                        </td>
			                    </tr>
			                    <tr>
			                        <td width="100" style="">
			                            <label>Invoice Date: '.$invoice_date.'</label>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td style="">
			                            <label>Due Date: '.$due_date.'</label>
			                        </td>
			                        <td width="20" align="left" valign="top">&nbsp;</td>
			                </table>
			            </td>
			            </tr>
			            <tr>
			                <td width="20" align="right" valign="top">
			                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			                        <tr>
			                            <td width="20" align="right" valign="top">&nbsp;</td>
			                            <td align="left" valign="top" style="padding:10px 0;">
			                                <h2 style="font-size: 19px;color: #01cdfe;text-decoration:none;">Invoice To</h2>
			                                	'.$user_address.'
			                                
			                            </td>
			                            <td align="left" valign="top" style="padding:10px 0;">
			                                <h2 style="font-size: 19px;color: #01cdfe;text-decoration:none;">Vehicle details</h2>
			                                	'.$vehicle_detail.'
			                            </td>
			                            <td width="20" align="left" valign="top">&nbsp;</td>
			                        </tr>
			                    </table>
			                </td>
			            </tr>

			            <tr>
			                <td width="20" align="left" valign="top">
			                    <table border="0" cellspacing="0" cellpadding="0" style="background-color: #74BF4C;padding: 12px 9px;width:100%">
			                        <tr>
			                            <td align="left" valign="top" width="200">
			                                <h2 style="font-size: 24px;color: #fff;text-decoration:none; margin:0;">Service Packages</h2></td>
			                            <td align="left" valign="top" style="padding:10px 0; ">

			                            </td>
			                        </tr>

			                    </table>
			                </td>
			            </tr>
			            <tr>
			                <td width="20" align="right" valign="top">
			                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			                        <tr>
			                            <td align="left" valign="top" style="padding:10px 0;width:50%">
			                                <table border="0" cellspacing="0" cellpadding="0" style="    padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
			                                    <thead>
			                                        <tr style="background-color: #ccc;">
			                                            <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0;text-align:center;">Main Service</th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align:center;">Duration </th>
			                                            <th width="20" style="border: 1px solid #eeeeee;text-align:center;">Cost </th>

			                                        </tr>
			                                    </thead>
			                                    <tbody>
			                                        <tr>
			                                            '.$main_service.'

			                                        </tr>
			                                    </tbody>
			                                </table>

			                            </td>
			                            <td align="right" valign="top" style="padding:10px 0;width:50%">
			                                '.$added_service.'
			                            </td>
			                        </tr>
			                    </table>
			                </td>
			            </tr>

			            <tr>
			                <td width="20" align="right" valign="top">
			                    <table border="0" cellspacing="0" cellpadding="0" style="padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
			                        <tbody>
			                            <tr style="background-color: #ccc;">
			                                <td width="20" align="right" style="border: 1px solid #eeeeee; padding: 10px 6px;"><strong>Total</strong></td>
			                                <td width="20" style="border: 1px solid #eeeeee; text-align: center;"><strong>KSH '.$total_amount.'</strong></td>

			                            </tr>
			                        </tbody>

			            </tr>
			            </table>
			</div>';
			//echo $put_data; die;
				$dompdf->loadHtml($put_data);
				$dompdf->setPaper('A3', 'portrat');
				 $dompdf->render();

				$final = $dompdf->output();
				$path = "app/public/generated_pdf/".$name.'.pdf';
				$file = storage_path($path);
				 file_put_contents(storage_path("app/public/generated_pdf/".$name.'.pdf'), $final);
				 $url = url("/");
				 $url_name = explode("/",url("/"));
				array_pop($url_name);
				$final = implode("/",$url_name);

				 return $final."/storage/".$path;
		}
*/
	
}
