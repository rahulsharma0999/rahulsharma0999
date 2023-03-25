<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\ResponseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
Use App\User;
use GuzzleHttp;
use Hash;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
date_default_timezone_set("UTC");
class HomeController extends ResponseController
{
   // protected $redirectTo = '/superAdmin/dashboard';
    
	public function __construct(){
        // $this->middleware('guest')->except('superAdmin/login');
    }
//*************************************************//	
	public function login(Request $request){
		if(Auth::check()){
			return redirect('superAdmin/dashboard');
		}
		if($request->isMethod('post')){
		//	echo '<pre>';
		//	print_r($request->all());die;
			$validator = Validator::make($request->all(),[
				//'email' => 'required',
				'password' => 'required',
			]);
			  if($validator->fails()){
			  $this->responseWithError($validator->errors()->first());
			  exit;
		    }
			$email = $request->input('email');
			$password = $request->input('password');
		    $login_token = Str::random(32);
			$request->session()->put('login_token', $login_token);
			//$email
			if (Auth::attempt(['email' =>$email,'password' =>$password,'role' =>1]) || Auth::attempt(['phoneNumber' =>$email,'password' =>$password,'role' =>1])){
				// Authentication passed...
				DB::table('users')->where(['email'=>$email])->update(['login_token'=>$login_token]);
				return redirect('superAdmin/dashboard');
			}else{
				$message = array('email or password does not match');
				return back()->withErrors($message)->withInput();
			}
		}else{
			return view('superAdmin/login');
		}
	}
	//********************************************//
	public function signup(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|unique:users',
			'password' => 'required',
		]);
		
		if($validator->fails()){
			$this->responseWithError($validator->errors()->first());
			exit;
		}
		$device_token = !empty($request->input('device_token')) ? $request->input('device_token'):'';
		$device_type = !empty($request->input('device_type')) ? $request->input('device_type'):'';
		$password = $request->input('password');
		$email = $request->input('email');
		$insert_user = User::insertGetId(['name' => $request->input('name'),'email' => $email,'password' => Hash::make($password),'visibsle_pwd' =>$request->input('password'),'created_at' => Date('Y-m-d H:i:s'),'updated_at' => Date('Y-m-d H:i:s'),'refresh_token' => '','device_token' => $device_token, 'device_type' => $device_type]);
		if($insert_user){
			$http = new GuzzleHttp\Client;
			$url = Url('oauth/token');
			$response = $http->post($url, [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => 2,
					'client_secret' => 'OJZMQ9Ef4gYdxxsdfvUubdbbX0BzsWolWg5wKwAC',
					'username' => $email,
					'password' => $password,
					'scope' => '*',
				],
			]);
			$return_data = json_decode($response->getBody(), true);
			if(!empty($return_data)){
				$update_refresh_token = User::where(['id' => $insert_user])->update(['refresh_token' => $return_data['refresh_token']]);
				$this->responseOk('Registration has been Successfully done','');
			}
		}else{
			$this->responseWithError('oops Something Wrong');
		}
	}
//************************************************************//	
	public function forgotPassword(Request $request){

		if($request->isMethod('post')){
			//print_r($request->all());die;
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
			]);
			
			if($validator->fails()){
				return back()->withErrors($validator)->withInput();
			}
			$check_user_exist = User::where(['email'=>$request->input('email'),'role'=>1])->first();
			if(!empty($check_user_exist)){
				$reset_password_token = str_random(40);
				$url = ('http://pw.co.ke/superAdmin/reset-password/'.$reset_password_token);
				$update_data = User::where('id',$check_user_exist->id)->update(['reset_password_token' => $reset_password_token, 'updated_at' => Date('Y-m-d H:i:s')]);
				try{
					$user_data = User::where('id',$check_user_exist->id)->first();
					Mail::send('email_forget',['url' => $url,'user_data' => $user_data], function ($m) use ($user_data) {
						$m->from(env('MAIL_FROM'), 'sda connect');
						$m->to($user_data->email,'App User');
						//$m->cc('deftsofttesting786@gmail.com','App User');
						$m->subject('Forgot Password link');
					});
					$message = array('Mail has been sent to your registered email Address');
					return back()->withErrors($message)->withInput();
				}catch(\Exception $e){
					$message = array('Oops Something wrong! '.$e->getMessage());
					return back()->withErrors($message)->withInput();
				}
			}else{
				$message = array('Old password does not match with your account');
				return back()->withErrors($message)->withInput();
			}
		}else{
			return view('superAdmin/forget-password');
		}
	}
//************************************************************//	
	public function resetPassword(Request $request,$token){	
        
		$check_token = User::where(['forgot_verification_token' => $token, 'status'=> 1])->first();
		
		if(!empty($check_token)){
            $current_time = Carbon::now();
            $startTime = Carbon::parse($current_time);
            $finishTime = Carbon::parse($check_token->updated_at);
            $difference= $finishTime->diffInMinutes($startTime); 
            if($difference > 9){
                return view('pageNotFound404');
            }
            if($request->isMethod('post')){
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password',
                ]);
                if($validator->fails()){
                   // return redirect('admin/reset-password/'.$token)->withErrors($validator)->withInput();
                    return back()->withErrors($validator)->withInput();
                }
                 //$login_token = Str::random(32);
                $update_data = User::where('id',$check_token->id)
                ->update(['password' => Hash::make($request->input('password')),
                    'visible_pwd' => $request->input('password'), 
                        'updated_at' =>Date('Y-m-d H:i:s'),
                    'reset_password_token' => '','reset_password_token' => '']);
                Session::flash('success', 'Your Password has been changed Successfully.');
                return view('success');
			}else{
				return view('reset_password');
			}
		}else{
			return view('pageNotFound404');
		}
	}
//********************************************************//
		public function verifyEmail(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'username' => 'required',
				
		]);
		
		if($validator->fails()){
			$this->responseWithError($validator->errors()->first());
			exit;
		}
		
		if(!empty($request->input('email'))){
			$check_email = User::Where(['email' => $request->input('email')])->first();		
			if(!empty($check_email)){
				
				$this->responseWithError('Email already exist');exit;
			}else{			
				// $this->responseOk('No email registered with account','');
			
				if(!empty($request->input('username'))){
					$check_username = User::Where(['username' =>$request->input('username')])->first();
					if(!empty($check_username)){				
						$this->responseWithError('Username already exist');exit;
					}else{			
						$this->responseOk('No Username registered with account','');
					}
				}
			}
		}
		
		
		
	}
	//**************************************//
	//try{
								
								//Mail::send('email_verify',['random_number' => $number,'username'=>$name], function ($m) use ($email) {
									//$m->from('tt35093@gmail.com' ,'SDA-Connect');
									//$m->to($email,'App User');
								//	$m->subject('Email verification link');
							//	});
								
							// }catch(\Exception $ex){
								// $this->responseOk('Your account login process has been completed Successfully email varification code send to your email address. Please verify your email for login','');
							//} 
							
	
}
