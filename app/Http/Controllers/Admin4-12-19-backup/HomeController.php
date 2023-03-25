<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
use Redirect;
use Carbon\Carbon;
//date_default_timezone_set('Africa/Nairobi');
date_default_timezone_set("UTC");
class HomeController extends Controller
{
    
	

    public function login(Request $request){

        if(Auth::check()){
            return redirect('admin/dashboard');
        }
        if($request->isMethod('post')){
         
              if($request->isMethod('POST')){
            $messages = [
            'email.email'       =>  'Please enter valid email address.',
            'email.exists'      =>  'Please enter registered email address.',
            'email.required'    =>  'Please enter email address.',
            'password.required' =>  'Please enter password.'
            ];

            $data = $this->validate($request, [
                'email'    => 'required|email|exists:users',
                'password' => 'required|min:6',
            ], $messages);

            $email = $request->email;
            $password = $request->password;
            }
            $email = $request->input('email');
            $password = $request->input('password');
         
           
            //$email
            if (Auth::attempt(['email' =>$email,'password' =>$password,'role' =>1])){
             
              
                return redirect('admin/dashboard');
            }else{
                 Session::flash('message','Email address or password does not match');
                return back()->withInput();
            }
        }else{
            return view('admin/login');
        }
    }

    public function changePassword(Request $request)
    {  
        if($request->isMethod('post')){
            
            $validator = Validator::make($request->all(),[
                'old_password'   =>'required',
                'new_password' => 'required|min:6|max:50',
                'confirm_password'=>'required|same:new_password',
            ]);
            
            if($validator->fails()){
                return Redirect:: back()->withErrors($validator)->withInput();
            }
            $data = DB::table('users')->where(['role'=>1])->first();
            if(Hash::check($request->input('old_password'),$data->password)){
                $update_data = User::where('id',$data->id)->update(['password' => Hash::make($request->input('new_password')),'visible_pwd'=>$request->input('new_password'), 'updated_at' => Date('Y-m-d H:i:s')]);
                Session::flash('message','Your password has been changed Successfully');
                 Auth::logout();
                return redirect('admin/login');
                //return redirect('superAdmin/login');
            }else{
                $error = 'Old password does not match';
                return redirect('admin/change-password')->withErrors($error);
            }
        }else{
                return view('admin/change-password');
            }
    }
    

     public function forgotPassword(Request $request){

        if($request->isMethod('post')){
              $message = array('email.required' => 'Please enter registered email address.',
                'email.email'=>'Please enter valid email address',
                'email.exists'=>'Enter registered email address'
            );
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'email' => 'required|email|exists:users,email',
            ],$message);
            
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $check_user_exist = User::where(['email'=>$request->input('email'),'role'=>1])->first();
            if(!empty($check_user_exist)){

                $reset_password_token = str_random(40);
                //$url = ('http://pw.co.ke/admin/reset-password/'.$reset_password_token);
                $url = url('admin/reset-password/'.$reset_password_token);
                
                $update_data = User::where('id',$check_user_exist->id)->update(['reset_password_token' => $reset_password_token, 'updated_at' => Date('Y-m-d H:i:s')]);
               
                try{
                    $user_data = User::where('id',$check_user_exist->id)->first();
                    Mail::send('email_forget',['url' => $url,'user_data' => $user_data], function ($m) use ($user_data) {
                        $m->from(env('MAIL_FROM'), 'PreshaWash');
                        $m->to($user_data->email,'App User');
                        //$m->cc('deftsofttesting786@gmail.com','App User');
                        $m->subject('Forgot Password link');
                    });
                    Session::flash('message','Forgot password email has been sent to your registered email address.');
                    return back()->withErrors($message)->withInput();
                }catch(\Exception $e){
                    $message = array('Oops Something wrong! '.$e->getMessage());
                    return back()->withErrors($message)->withInput();
                }
            }else{
                $message = array('This mail address does not register with us');
                return back()->withErrors($message)->withInput();
            }
        }else{
            return view('admin/forgot-password');
        }
    }


    public function resetPassword(Request $request,$token){
       //return $token;
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
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password',
                ]);
                if($validator->fails()){
                    return redirect('admin/reset-password/'.$token)->withErrors($validator)->withInput();
                }
                 //$login_token = Str::random(32);
                $update_data = User::where('id',$check_token->id)
                ->update(['password' => Hash::make($request->input('password')),
                    'visible_pwd' => $request->input('password'), 
                        'updated_at' =>Date('Y-m-d H:i:s'),
                    'reset_password_token' => '','reset_password_token' => '']);
                Session::flash('success', 'Your password has been changed Successfully.');
                 return redirect(route('passwordReset'));
            }else{
                return view('admin.reset-password');
            }
            
        }else{
            return redirect(route('passwordResetInvalid'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect ('admin/login');
    }

         public function viewMessageResetPassword()
    {
        // $link = url("/login");
        $title = "Password Reset Success";
        $message = "Password has been reset successfully.";
        $type = "success";
        
        return view('admin.feedback', compact('title', 'message', 'type'));
    }

    public function viewMessageResetPasswordInvalid()
    {
        $title = "Invalid link";
        $message = "The email link you clicked is invalid or has expired.";
        $type = "danger";
        return view('admin.feedback', compact('title', 'message', 'type'));
    }
}
