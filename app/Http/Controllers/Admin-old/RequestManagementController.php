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


class RequestManagementController extends Controller
{
    public function requestListing_old(Request $request)
    {
          $request_list=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->orderBy('requests.id','Desc')
            ->get(); 

        return view('admin.request-listing',['requests'=>$request_list]);
    }

    public function requestListing(Request $request)
    {
          $request_list=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->leftJoin('request_add_on_services','request_add_on_services.request_id','=','requests.id')
            ->Where('requests.main_service_status','!=',3)
            ->orWhere('request_add_on_services.service_status','!=',3)

            ->select('users.*','services.*','request_add_on_services.request_id','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->orderBy('requests.id','Desc')
            ///new code implement by shubam
            ->groupBy('request_add_on_services.request_id')
            ->get(); 

        return view('admin.request-listing',['requests'=>$request_list]);
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

        $get_add_on_services=DB::table('request_add_on_services')
            ->leftJoin('add_on_services','add_on_services.id','=','request_add_on_services.add_on_service_id')
             ->where(['request_add_on_services.request_id'=>$request->request_id])
            ->get(); 

         
      if($request_detail->van_id ==0){
			$service_vans=DB::table('users')->where(['role'=>3])->get();
            foreach ($service_vans as  $service_van) {
                      $distance=$this->distance($request_detail->lat,$request_detail->lng,$service_van->latitude,$service_van->longitude,'N');
                    $service_van->distance=round($distance);
              }
             
		}else{
			$service_vans=DB::table('users')->where('id','=',$request_detail->van_id)->where(['role'=>3])->get();
			foreach ($service_vans as  $service_van) {
                      $distance=$this->distance($request_detail->lat,$request_detail->lng,$service_van->latitude,$service_van->longitude,'N');
                    $service_van->distance=round($distance);
              }
		}

       return view('admin.request-detail',['request'=>$request_detail,'service_vans'=>$service_vans,'add_on_services'=>$get_add_on_services]);
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

      if ($unit == "K") {
          return ($miles * 1.609344);
      } else if ($unit == "N") {
          return ($miles * 0.8684);
      } else {
          return $miles;
      }
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
        
       //$service_vans=DB::table('service_vans')->get();
        $service_vans=DB::table('users')->where(['role'=>3])->get();
        $get_review= DB::table('reviews')->where(['request_id'=>$request->request_id])->first(); 
       return view('admin.past-request-detail',['request'=>$request_detail,'service_vans'=>$service_vans,'review'=>$get_review]);
    }

    public function acceptRequest_old(Request $request)
    {
      
       $update_data['van_id']=$request->van_id;
       $update_data['request_status']=2;
       DB::table('requests')->where(['id'=>$request->request_id])->update($update_data);
        $get_request=DB::table('requests')->where(['id'=>$request->request_id])->first();
        $message='Your service request is accepted.';
        $notfy_key=1;
        $notfy_message = array('sound' =>1,'message'=>'Your service request is accepted.',
        'notifykey'=>'1');
         $get_user=DB::table('users')->where(['id'=>$get_request->user_id])->first();      
         $get_van=DB::table('users')->where(['id'=>$get_request->van_id])->first();      
      
      //notification to user  
      if($get_user->device_type == 'android'){
				 $this->android($get_user->device_token,$message,$notfy_key,$notfy_message);
			}elseif($get_user->device_type == 'ios'){
			
			  $this->send_iphone_notification($get_user->device_token,$message,$notfy_key,$notfy_message);
			}
      //notification to van
      $van_message='Admin is allocated a new job.';
      $van_notfy_message = array('sound' =>1,'message'=>'Admin is allocated you a new job.',
        'notifykey'=>'1');

      if($get_van->device_type == 'android'){
         $this->android($get_user->device_token,$van_message,$notfy_key,$van_notfy_message);
      }elseif($get_van->device_type == 'ios'){
        $this->send_iphone_notification($get_user->device_token,$van_message,$notfy_key,$van_notfy_message);
      }
        

        Session::flash('message','Service request accepted successfully.');
        return redirect('admin/request-listing');
       
    }
	
	
	 public function acceptRequest(Request $request)
    {
      
      $update_data['van_id']=$request->van_id;
      $update_data['request_status']=2;
      DB::table('requests')->where(['id'=>$request->request_id])->update($update_data);
      $get_request=DB::table('requests')->where(['id'=>$request->request_id])->first();
      $message='Your service request is accepted.';
      $notfy_key=3;
     	$service=$this->getServiceDetail($request->request_id);
      
      $notfy_message = array('sound' =>1,'message'=>'Your service request is accepted.',
      'notifykey'=>'3','service_detail'=>$service);
      $get_user=DB::table('users')->where(['id'=>$get_request->user_id])->first();      
      $get_van=DB::table('users')->where(['id'=>$get_request->van_id])->first();      
      
      $get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
      if($get_user->device_type == 'android'){
				 $this->android($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
			}elseif($get_user->device_type == 'ios'){
			  $this->send_iphone_notification($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
			}
      //notification to van
      $van_message='Admin is allocated you a new job.';
      $van_notfy_message = array('sound' =>1,'message'=>'Admin is allocated you a new job.',
        'notifykey'=>'1','service_detail'=>$service);

      if($get_van->device_type == 'android'){
         $this->android($get_van->device_token,$van_message,$notfy_key,$van_notfy_message,$service);
      }elseif($get_van->device_type == 'ios'){
        $this->send_iphone_notification($get_van->device_token,$van_message,$notfy_key,$van_notfy_message,$service);
      }
        
        $save_notf['user_id']=$get_user->id;
        $save_notf['notification']=$message;
        $save_notf['notification_type']=$notfy_key;
        $save_notf['service_name']=$get_service->service_name;
        $save_notf['service_duration']=$get_service->service_duration;
        $save_notf['request_id']=$request->request_id;
        $save_notf['created_at']=Date('y-m-d H:i:s');
            
        DB::table('notifications')->insertGetId($save_notf);

        $save_notf['user_id']=$get_van->id;
        $save_notf['notification']=$van_message;
        $save_notf['notification_type']=$notfy_key;
        $save_notf['service_name']=$get_service->service_name;
        $save_notf['service_duration']=$get_service->service_duration;
		 $save_notf['request_id']=$request->request_id;
        $save_notf['created_at']=Date('y-m-d H:i:s');
            
        DB::table('notifications')->insertGetId($save_notf);
       
        Session::flash('message','Service request accepted successfully.');
        return redirect('admin/request-listing');
       
    }
	
	public function getServiceDetail($request_id)
	{
		 	$get_service_requests=DB::table('requests')
           	->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
           	->where(['requests.id'=>$request_id])
           	->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
           	->first();
       
		return $get_service_requests;
		
	}

    public function getServiceDetail_old($request_id)
	{
		/* $user_id=$this->checkUserExist();
		$validator = Validator::make($request->all(),[
			'service_id' =>'required|exists:requests,id',
		  	'user_type' =>['required',Rule::in(['2', '3'])],
			
		]);
		//print_r($user_id->id);die();
		if($validator->fails()){
			return $this->responseWithError($validator->errors()->first());
		} */
	    $get_service_requests=DB::table('requests')->where(['requests.id'=>$request_id])->select('service_duration as job duration','service_address as job_location_name','lat as job_location_lat','lng as job_location_lng','requests.service_date as job_date','requests.service_time as job_time','requests.service_address as job_address','requests.*')->first();
        	
        $get_service_requests->vehicle_detail=DB::table('vehicles')->where(['id'=>$get_service_requests->vehicle_id])
		->select('id as vehicle_id','name as vehicle_name','model as vehicle_model','license_plate_no as vehicle_license_plate_no','brand as vehicle_brand','type as vehicle_type','colour as vehicle_colour')
		->first();  	
       
     	return $get_service_requests;
	}


     public function deleteRequest(Request $request)
    {
       $get_request =  DB::table('requests')->where(['id'=>$request->request_id])->first();
        $message='Your service request is declined.';
        $notfy_key=4;
     	$service=$this->getServiceDetail($request->request_id);
      
      $notfy_message = array('sound' =>1,'message'=>'Your service request is declined.',
      'notifykey'=>'4','service_detail'=>$service);
      $get_user=DB::table('users')->where(['id'=>$get_request->user_id])->first();      
      
      
      $get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
      if($get_user->device_type == 'android'){
				 $this->android($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
			}elseif($get_user->device_type == 'ios'){
			  $this->send_iphone_notification($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
			}
        DB::table('requests')->where(['id'=>$request->request_id])->delete();
        DB::table('reviews')->where(['request_id'=>$request->request_id])->delete();
        DB::table('payments')->where(['request_id'=>$request->request_id])->delete();
        Session::flash('message','Service request deleted successfully.');
        return redirect('admin/request-listing');
       
    }

     public function pastRequests_old(Request $request)
    {
      
        
       $request_list=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->where(['requests.service_status'=>3])
            ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id')
            ->orderBy('requests.id','Desc')
            ->get();

       
        return view('admin.past-requests',['requests'=>$request_list]);
       
    }

     public function pastRequests(Request $request)
    {
      
        
       $request_list=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->leftJoin('request_add_on_services','request_add_on_services.request_id','=','requests.id')
            ->where('requests.main_service_status','=',3)
            ->where('request_add_on_services.service_status','=',3)
           ->distinct('requests.id')
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

    public function android($device_token,$message,$notmessage='',$sender_id='',$data_message) 
    {
        #API access key from Google API's Console
       //define('API_ACCESS_KEY', '');

       $API_ACCESS_KEY = 'AAAA5Htr6lQ:APA91bHSEJC1QX2gMwfHUQK3-xufV4lya7pZd_6RUqmOKrWbkPEeBHyJKo0SeLX2Ee7z0V8LpwJQMudfnZAyAfsz3uLLDJqRBcnnearx2JqBd3k-cvSG9EkfVtt0S_5JQL-8fjmiO-_n';
        $registrationIds = $device_token;
        #prep the bundle
         $msg = array( 
                'title' => "Water works",
                'body'  => $message
                    // 'icon'   => 'default',/*Default Icon*/
                    //  'sound' => 'default',/*Default sound*/
                    //'data'    => $details
         );
		

         $details = array('Notifykey' => $notmessage, 
                    'msgsender_id'=>$sender_id,
                    'service_detail' => $data_message
                    );
        $fields = array(
            'to'=> $registrationIds,
            'notification'  => $msg,
            'data'  => ($details),
        );
        
        // echo json_encode($fields);die();

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
	
	 public function send_iphone_notification($receiver_id,$message,$notmessage='',$sender_id, $data_message)
    {  

          //  $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PEMFile.pem";
            $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PushPem.pem";
          
			//print $PATH;die;
            $deviceToken = $receiver_id;
            $passphrase = "123456";
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
            // print_r($result);exit;
            
            // if (!$result)
                // echo 'Message not delivered' . PHP_EOL;
            // else
                // echo 'Message successfully delivered' . PHP_EOL;
            // exit;
            fclose($fp);
			  
        } 

    

}
