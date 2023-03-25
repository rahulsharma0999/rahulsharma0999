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
        
        return view('admin.view-vehicle-detail',['van'=>$get_van]);
    }


     public function editVehicleDetail(Request $request)
    {
       $get_van=DB::table('vehicle_types')->where('id',$request->id)->first();
       if($request->isMethod('post')){
            $custom_msgs=array('type.required'=>'Please enter vehicle Type Name');
            $validator = Validator::make($request->all(), [
                    'type' => 'required|min:2|max:30',
                  
            ],$custom_msgs);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $update_data['type']=$request->type;
           
            DB::table('vehicle_types')->where('id',$request->id)->update($update_data);
            Session::flash('message','Vehicle type detail updated successfully');
            return Redirect('admin/vehicle-listing');

       }
        
       return view('admin.edit-vehicle-detail',['van'=>$get_van]);  
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
            $custom_msgs=array('type.required'=>'Please enter vehicle Type Name');
            $validator = Validator::make($request->all(), [
                    'type' => 'required|min:2|max:30',
                  
            ],$custom_msgs);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }


            $save_data['type']=$request->type;
            
            $save_data['created_at'] = Date('y-m-d H:i:s');
           
            $last_id=DB::table('vehicle_types')->insertGetId($save_data);
          
            Session::flash('message','Van added successfully');
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
                $m->cc('deftsofttesting786@gmail.com','App User');
                $m->subject($subject);
            });
            return array('status' => 1, 'msg' => 'done');
        }catch(\Exception $e){
            return array('status' => 2,'msg' => 'Oops Something wrong! '.$e->getMessage());
        }
    }

}
