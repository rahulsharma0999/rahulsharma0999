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
use Illuminate\Validation\Rule;
use DB;
use Session;
use Redirect;
use Carbon\Carbon;
date_default_timezone_set("UTC");
//date_default_timezone_set('Africa/Nairobi');
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);


class ServiceVanManagementController extends Controller
{
    public function serviceVanListing(Request $request)
    {
        $get_vans=DB::table('users')->orderBy('id','Desc')->where(['role'=>3])->get();       
        return view('admin.service-van-listing',['vans'=>$get_vans]);
    }
    
    public function viewVanDetail(Request $request)
    {
        $get_van=DB::table('users')->where(['id'=>$request->id,'role'=>3])->first();
        $get_crew_members=DB::table('crew_members')->where('service_van_id',$request->id)->get();

        return view('admin.view-van-detail',['van'=>$get_van,'crew_members'=>$get_crew_members]);
    }


     public function editVanDetail(Request $request)
    {
       $get_van=DB::table('users')->where('id',$request->id)->first();
       if($request->isMethod('post')){
            $custom_msgs=array('email.required'=>'Please enter email');
            $validator = Validator::make($request->all(), [
                    'van_name' => 'required|min:2|max:30',
                    //'number' => 'required|unique:users,number,'.$request->id,
                    'email' => 'required|email|unique:users,email,'.$request->id,
                    'license_plate_no' => 'required|unique:users,license_plate_no,'.$request->id,
            ],$custom_msgs);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $update_data['name']=$request->van_name;
           // $update_data['number']=$request->number;
            $update_data['email']=$request->email;
            $update_data['license_plate_no']=$request->license_plate_no;
            DB::table('users')->where('id',$request->id)->update($update_data);
            Session::flash('message','Van detail updated successfully');
            return Redirect('admin/service-van-listing');

       }
        
       return view('admin.edit-van-detail',['van'=>$get_van]);  
    }


    public function addNewVan_old(Request $request)
    {
       if($request->isMethod('post')){
            $custom_msgs=array('email.required'=>'Please enter email');
            $validator = Validator::make($request->all(), [
                    'van_name' => 'required|min:2|max:30',
                    'number' => 'required|unique:service_vans,number',
                    'email' => 'required|email|unique:service_vans,email',
                    'license_plate_no' => 'required|unique:service_vans,license_plate_no',
                    'password' => 'required',
            ],$custom_msgs);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $save_data['name']=$request->van_name;
            $save_data['number']=$request->number;
            $save_data['email']=$request->email;
            $save_data['license_plate_no']=$request->license_plate_no;
            $save_data['visible_password']=$request->password;
            $save_data['password']=Hash::make($request->password);

            DB::table('service_vans')->insertGetId($save_data);
            Session::flash('message','Van added successfully');
            return Redirect('admin/service-van-listing');

       }
        
       return view('admin.add-new-van');  
    }

    public function addNewVan(Request $request)
    {
       if($request->isMethod('post')){
            $custom_msgs=array('email.required'=>'Please enter email');
            $validator = Validator::make($request->all(), [
                    'van_name' => 'required|min:2|max:30',
                   // 'number' => 'required|unique:users,number',
                    'email' => 'required|email|unique:users,email',
                    'license_plate_no' => 'required|unique:users,license_plate_no',
                    'password' => 'required|min:6',
            ],$custom_msgs);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }


            $save_data['full_name']=$request->van_name;
            $save_data['name']=$request->van_name;
           
            $save_data['email']=$request->email;
            $save_data['license_plate_no']=$request->license_plate_no;
            $save_data['visible_pwd']=$request->password;
            $save_data['password']=Hash::make($request->password);
            $save_data['created_at'] = Date('y-m-d H:i:s');
            $save_data['block_status'] =1;
            $save_data['role'] =3;
            $save_data['status'] =1;
            $last_id=DB::table('users')->insertGetId($save_data);
            $update_id['number']='van_'.$last_id;
            DB::table('users')->where(['id'=>$last_id])->update($update_id);
           

            $return_data = $this->signupAccessToken($request->email,$request->password,$last_id);
            if(empty($return_data) || $return_data['status'] == 2){
                return $this->responseWithError('Oops Something wrong in token!');
            }
            $check_user = User::find($last_id); 
            $token = encrypt($check_user->id);
            $check_user->email_verification_token = $token;
            $check_user->save();
            $url = url('verify/email/'.$token);
            $mail_status = $this->sendMail($check_user->email,'email_verify','Verify Email address',$data = array('url' => $url, 'user_data' => $check_user));
            Session::flash('message','Van added successfully');
            return Redirect('admin/service-van-listing');

       }
        
       return view('admin.add-new-van');  
    }

    public function deleteVan(Request $request)
    {
        DB::table('users')->where('id',$request->row_del)->delete();
        Session::flash('message','Service Van deleted successfully');
        return Redirect('admin/service-van-listing');

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

    public function sendMail($email_to,$mail_template,$subject,$data = array()){
    
        try{
            Mail::send($mail_template,$data, function ($m) use ($data,$email_to,$subject) {
                $m->from(env('MAIL_FROM'), 'Water works');
                $m->to($email_to,'App User');
                $m->cc('support@pw.co.ke','App User');
                $m->subject($subject);
            });
            return array('status' => 1, 'msg' => 'done');
        }catch(\Exception $e){
            return array('status' => 2,'msg' => 'Oops Something wrong! '.$e->getMessage());
        }
    }

}
