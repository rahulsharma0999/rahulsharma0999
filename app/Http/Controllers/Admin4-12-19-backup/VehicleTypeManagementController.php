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
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
//date_default_timezone_set('Africa/Nairobi');
date_default_timezone_set("UTC");

class VehicleTypeManagementController extends Controller
{
    public function VehicleListing(Request $request)
    {
        $get_vans=DB::table('vehicle_types')->orderBy('id','Desc')->get();       
        return view('admin.vehicle-listing',['vans'=>$get_vans]);
    }
    
    public function viewVehicleDetail(Request $request)
    {
        $get_van=DB::table('vehicle_types')->where(['id'=>$request->id])->first();
        $get_service = DB::table('services')->where('vehicle_type_id',$get_van->id)->first();
        return view('admin.view-vehicle-detail',['van'=>$get_van,'service'=>$get_service]);
    }


     public function editVehicleDetail(Request $request)
    {
       $get_van=DB::table('vehicle_types')->where('id',$request->id)->first();
       $get_service = DB::table('services')->where('vehicle_type_id',$get_van->id)->first();
       if($request->isMethod('post')){



       // @$ip = $_SERVER['REMOTE_ADDR'];
        
        //@$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        //@$ipInfo = json_decode($ipInfo);
       // if($ipInfo->status == "fail"){
        // date_default_timezone_set("UTC");
        //}else {
        //@$timezone = $ipInfo->timezone;
        //date_default_timezone_set(@$timezone);
        //}


             $errors = array(
             'type.required'=>'Please enter vehicle type',
            'service_price.required'=>'Please enter service price',
            'service_duration.required'=>'Please enter service duration',
            'service_description.required'=>'Please enter service description',
            );
            $validator = Validator::make($request->all(), [
             'type'=>'required|max:30',
             'service_price' => 'required|numeric',
             'service_duration' => 'required||date_format:H:i',
             'service_description' => 'required|max:250'
                  
            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

             $check_time=explode(':',$request->service_duration);

             if($check_time[0] == "00"){

                if($check_time[1] < '15'){
            
            
                    return back()->with('message','The service duration must be at least 15 minutes');
                }
             }


            $update_data['type']=$request->type;

            $service_duration = $request->input('service_duration');
            $service_desctiption = $request->input('service_description');
            $service_price = $request->input('service_price');
           $update_data['created_at']=Date('Y-m-d H:i:s');
            DB::table('vehicle_types')->where('id',$request->id)->update($update_data);
            DB::table('services')->where(['vehicle_type_id'=>$request->id])->update(['description'=>$service_desctiption,'service_duration'=>$service_duration,'service_price'=>$service_price]);
            Session::flash('message','Vehicle type detail updated successfully');
            return Redirect('admin/vehicle-listing');

       }
        
       return view('admin.edit-vehicle-detail',['van'=>$get_van,'service'=>$get_service]);  
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

    public function addNewVehicle(Request $request)
    {
       if($request->isMethod('post')){
            $errors = array(
             'type.required'=>'Please enter vehicle type',
            'service_price.required'=>'Please enter service price',
            'service_duration.required'=>'Please enter service duration',
            'service_description.required'=>'Please enter service description',
            );
            $validator = Validator::make($request->all(), [
             'type'=>'required|max:30',
             'service_price' => 'required|numeric',
             'service_duration' => 'required||date_format:H:i',
             'service_description' => 'required|max:250'
                  
            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
             $check_time=explode(':',$request->service_duration);
           
            if( $check_time[1] < '15' && $check_time[1] != '00'){
            

                //Session::flash('message','The service duration must be at least 30 minutes');
                return back()->with('message','The service duration must be at least 15 minutes');
            }

            $save_data['type']=$request->type;
            $service_duration = $request->input('service_duration');
            $service_desctiption = $request->input('service_description');
            $service_price = $request->input('service_price');
            $save_data['created_at'] = Date('Y-m-d H:i:s');
           
            $last_id=DB::table('vehicle_types')->insertGetId($save_data);

             $insert_data = DB::table('services')->insert(['vehicle_type_id'=>$last_id,'service_name'=>'Basic Wash','description'=>$service_desctiption,'service_duration'=>$service_duration,'vehicle_type'=>$request->type,'service_price'=>$service_price]);
            Session::flash('message','Vehicle added successfully');
            return Redirect('admin/vehicle-listing');

       }
        
       return view('admin.add-new-vehicle');  
    }

    public function deleteVan(Request $request)
    {
        DB::table('users')->where('id',$request->row_del)->delete();
        Session::flash('message','Service Van deleted successfully');
        return Redirect('admin/service-van-listing');

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
