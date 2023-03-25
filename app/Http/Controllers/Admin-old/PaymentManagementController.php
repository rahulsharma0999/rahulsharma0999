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


class PaymentManagementController extends Controller
{
    public function paymentListing(Request $request)
    {
          $request_list=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->orderBy('requests.id','Desc')
            ->get(); 

         $payments=DB::table('payments')->get(); 
        foreach ($payments as $payment) {
             $payment->request_detail=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->orderBy('requests.id','Desc')
            ->where('requests.id',$payment->request_id)
            ->first(); 
        }
        return view('admin.payment-listing',['payments'=>$payments]);
    }

    public function paymentDetail(Request $request)
    {
         $payment_detail=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->leftJoin('reviews','reviews.request_id','=','requests.id')
            ->where(['requests.id'=>$request->id])
             ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id','reviews.*')
            ->first();  
        return view('admin.payment-detail',['request'=>$payment_detail]);
    }

    public function requestDetail(Request $request)
    {
        //dd($request->request_id);
        $request_detail=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->where(['requests.id'=>$request->request_id])
             ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->first(); 

       $service_vans=DB::table('service_vans')->get();

       return view('admin.request-detail',['request'=>$request_detail,'service_vans'=>$service_vans]);
    }


    public function pastRequestDetail(Request $request)
    {
        //dd($request->request_id);
        $request_detail=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->where(['requests.id'=>$request->request_id])
             ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->first(); 

       $service_vans=DB::table('service_vans')->get();

       return view('admin.past-request-detail',['request'=>$request_detail,'service_vans'=>$service_vans]);
    }

    public function acceptRequest(Request $request)
    {
      
       $update_data['van_id']=$request->van_id;
       $update_data['request_status']=2;
        DB::table('requests')->where(['id'=>$request->request_id])->update($update_data);
        Session::flash('message','Service request accepted successfully.');
        return redirect('admin/request-listing');
       
    }

     public function deleteRequest(Request $request)
    {
      
        
        DB::table('requests')->where(['id'=>$request->request_id])->delete();
        Session::flash('message','Service request deleted successfully.');
        return redirect('admin/request-listing');
       
    }

     public function pastRequests(Request $request)
    {
      
        
       $request_list=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->orderBy('requests.id','Desc')
            ->get(); 

        return view('admin.past-requests',['requests'=>$request_list]);
       
    }

    public function editService(Request $request)
    {
        
         if($request->isMethod('post')){
            $errors = array(
            'service_name.required'=>'Please enter service name',
            'service_price.required'=>'Please enter service price',
            'service_hours.required'=>'Please enter service hours',
            );
           $validator = Validator::make($request->all(), [
             'service_name' => 'required|min:3|max:20',
             'service_price' => 'required|numeric',
             'service_duration' => 'required||date_format:H:i',

            ],$errors);
            
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            } 

            $update_data['created_at']=Date('Y-m-d H:i:s');
            $update_data['service_name']=$request->service_name;
            $update_data['service_price']=$request->service_price;
            $update_data['service_duration']=$request->service_duration;

            DB::table('services')->where(['id'=>$request->id])->update($update_data);
            Session::flash('message','Service updated successfully.');
            return redirect('admin/service-listing');

        }
          $service=DB::table('services')->where(['id'=>$request->id])->first();
        return view('admin.edit-service',['service'=>$service]);
    }

    public function createService(Request $request)
    {
        $errors = array(
            'service_name.required'=>'Please enter service name',
            'service_price.required'=>'Please enter service price',
            'service_hours.required'=>'Please enter service hours',
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

    public function deleteService(Request $request)
    {
        $services=DB::table('services')->where('id', $request->row_del)->delete();
        Session::flash('message','Service deleted successfully.');
        return redirect('admin/service-listing');
    }

    

}
