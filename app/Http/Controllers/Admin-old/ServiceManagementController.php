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


class ServiceManagementController extends Controller
{
    public function serviceListing_old()
    {
        $services=DB::table('services')->orderBy('id','Desc')->get();
        return view('admin.service-listing',['services'=>$services]);
    }


    public function serviceListing()
    {
        $services=DB::table('add_on_services')->orderBy('id','Desc')->get();
        return view('admin.service-listing',['services'=>$services]);
    }
    public function editService_old(Request $request)
    {
        
         if($request->isMethod('post')){
            $errors = array(
            'service_name.required'=>'Please enter service name',
            'service_price.required'=>'Please enter service price',
            'service_hours.required'=>'Please enter service hours',
            'service_description.required'=>'Please enter service description',
            );
           $validator = Validator::make($request->all(), [
             'service_name' => 'required|min:3|max:20',
             'service_price' => 'required|numeric',
             'service_duration' => 'required||date_format:H:i',
             'service_description' => 'required|max:250'

            ],$errors);
            
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
			$check_time=explode(':',$request->service_duration);
			if($check_time[1] < '30'){
				//Session::flash('message','The service duration must be at least 30 minutes');
				return back()->with('message','The service duration must be at least 30 minutes');
			}
			

            $update_data['created_at']=Date('Y-m-d H:i:s');
            $update_data['service_name']=$request->service_name;
            $update_data['service_price']=$request->service_price;
            $update_data['service_duration']=$request->service_duration;
            $update_data['service_description']=$request->service_description;

            DB::table('services')->where(['id'=>$request->id])->update($update_data);
            Session::flash('message','Service updated successfully.');
            return redirect('admin/service-listing');

        }
          $service=DB::table('services')->where(['id'=>$request->id])->first();
        return view('admin.edit-service',['service'=>$service]);
    }


    public function editService(Request $request)
    {
        
         if($request->isMethod('post')){
            $errors = array(
            'service_name.required'=>'Please enter service name',
            'service_price.required'=>'Please enter service price',
            'service_hours.required'=>'Please enter service hours',
            'service_description.required'=>'Please enter service description',
            );
           $validator = Validator::make($request->all(), [
             'service_name' => 'required|min:3|max:100',
             'service_price' => 'required|numeric',
             'service_duration' => 'required||date_format:H:i',
               'service_description' => 'required|max:250'
            ],$errors);
            
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $check_time=explode(':',$request->service_duration);
           
            if( $check_time[1] < '30' && $check_time[1] != '00'){
            

                //Session::flash('message','The service duration must be at least 30 minutes');
                return back()->with('message','The service duration must be at least 30 minutes');
            }

            
            

            $update_data['created_at']=Date('Y-m-d H:i:s');
            $update_data['service_name']=$request->service_name;
            $update_data['service_price']=$request->service_price;
            $update_data['service_duration']=$request->service_duration;
            $update_data['service_description']=$request->service_description;
            DB::table('add_on_services')->where(['id'=>$request->id])->update($update_data);
            Session::flash('message','Service updated successfully.');
            return redirect('admin/service-listing');

        }
          $service=DB::table('add_on_services')->where(['id'=>$request->id])->first();
        return view('admin.edit-service',['service'=>$service]);
    }

    public function createService_old(Request $request)
    {
        $errors = array(
            'service_name.required'=>'Please enter service name',
            'service_price.required'=>'Please enter service price',
            'service_hours.required'=>'Please enter service hours',
            //'service_duration.min'=>'The service duration must be at least 30 minutes.',
            );
         
        if($request->isMethod('post')){
           $validator = Validator::make($request->all(), [
             'service_name' => 'required|min:3|max:20',
             'service_price' => 'required|numeric',
             'service_duration' => 'required|date_format:H:i',

            ],$errors);
            
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
			$check_time=explode(':',$request->service_duration);
            if($check_time[1] < '30'){
				//Session::flash('message','The service duration must be at least 30 minutes');
				return back()->with('message','The service duration must be at least 30 minutes');
			}			
            $save_data['created_at']=Date('Y-m-d H:i:s');
            $save_data['service_name']=$request->service_name;
            $save_data['service_price']=$request->service_price;
            $save_data['service_duration']=$request->service_duration;

            DB::table('services')->insert($save_data);
            Session::flash('message','Service created successfully.');
            return redirect('admin/service-listing');

        }       
 
        return view('admin.create-service');
    }

     public function createService(Request $request)
    {
        $errors = array(
            'service_name.required'=>'Please enter service name',
            'service_price.required'=>'Please enter service price',
            'service_price.regex'=>'Please enter valid service price',
            'service_hours.required'=>'Please enter service hours',
            //'service_duration.min'=>'The service duration must be at least 30 minutes.',
              'service_description.required'=>'Please enter service description',
            );
         
        if($request->isMethod('post')){
           $validator = Validator::make($request->all(), [
             'service_name' => 'required|min:3|max:100',
             'service_price' => 'required|numeric|regex:/^[1-9][0-9]+/|not_in:0',
             'service_duration' => 'required|date_format:H:i',
              'service_description' => 'required|max:250'
            ],$errors);
            
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $check_time=explode(':',$request->service_duration);
           if( $check_time[1] < '30' && $check_time[1] != '00'){
                //Session::flash('message','The service duration must be at least 30 minutes');
                return back()->with('message','The service duration must be at least 30 minutes');
            }           
            $save_data['created_at']=Date('Y-m-d H:i:s');
            $save_data['service_name']=$request->service_name;
            $save_data['service_price']=$request->service_price;
            $save_data['service_duration']=$request->service_duration;
             $save_data['service_description']=$request->service_description;
            DB::table('add_on_services')->insert($save_data);
            Session::flash('message','Service created successfully.');
            return redirect('admin/service-listing');

        }       
 
        return view('admin.create-service');
    }

    public function deleteService_old(Request $request)
    {
        $services=DB::table('services')->where('id', $request->row_del)->delete();
        Session::flash('message','Service deleted successfully.');
        return redirect('admin/service-listing');
    }

     public function deleteService(Request $request)
    {
        $services=DB::table('add_on_services')->where('id', $request->row_del)->delete();
        Session::flash('message','Service deleted successfully.');
        return redirect('admin/service-listing');
    }

    

}
