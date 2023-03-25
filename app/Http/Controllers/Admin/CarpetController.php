<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use DB;
use App\CarpetService;
use App\CarpetMeasurement;

use Validator;
use Session;

use Illuminate\Http\Request;

class CarpetController extends Controller
{
    public function carpetService(Request $request){
    	if($request->isMethod("GET")){
        	$data = CarpetService::select("amount_per_square")->first();
            return view ("admin/carpet-service" , ["data"=>$data]);
        }

        if($request->isMethod("post")){
        	
        	$errors = array(
            'amount_per_square.required'=>'Please enter carpet price.',
            'amount_per_square.numeric'=>'Please enter numeric value only.',
            'amount_per_square.min'=>'Price should be greater than or equal to 1.',

            );
            $validator = Validator::make($request->all(), [
             'amount_per_square' => 'required|numeric|min:1',
                  
            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $data = [ 
                "amount_per_square" => $request->amount_per_square,
            ];

	        $checkdata = CarpetService::count();
	        $details = CarpetService::all()->first();
	            if($checkdata == 0){
	                $is_created = CarpetService::create($data);  
	                return redirect(url("admin/carpet-service"))->with("message" , "Price added successfully.");
	            }else{
	                $is_updated = CarpetService::where("id" , $details->id)->update($data);
	                return redirect(url("admin/carpet-service"))->with("message" , "Price updated successfully.");
	            }
   		}

   	}


    // public function requestCarpetDetail(Request $request){
    public function carpetNewList(Request $request)
    {
        $data = DB::table('request_carpets')
                        ->leftJoin('users','request_carpets.user_id','=','users.id')
                        ->Where('request_carpets.request_status','!=',3)
                        ->Where('request_carpets.final_status','=',1)
                        ->select('request_carpets.*','users.full_name','users.phone_number','users.email')
                        ->orderBy('request_carpets.id' , 'Desc')
                        ->get(); 

        return view('admin.carpet-new-list',['data'=>$data]);
    }


    public function carpetPastList(Request $request)
    {
        $data = DB::table('request_carpets')
                        ->leftJoin('users','request_carpets.user_id','=','users.id')
                        ->Where('request_carpets.request_status','!=',3)
                        ->Where('request_carpets.final_status','=',2)
                        ->select('request_carpets.*','users.full_name','users.phone_number','users.email')
                        ->orderBy('request_carpets.id' , 'Desc')
                        ->get(); 

        return view('admin.carpet-past-list',['data'=>$data]);
    }

//
    public function requestNewCarpetDetail(Request $request)
    {
        $data=DB::table('request_carpets')
            ->leftJoin('users','users.id','=','request_carpets.user_id')
            ->where(['request_carpets.id'=>$request->id])
            ->select('request_carpets.*','users.full_name','users.phone_number','users.email')
            ->first(); 

            // print_r($data); die();

        if($data->van_id ==0){
            $service_vans=DB::table('users')->where(['role'=>3])->get();
            foreach ($service_vans as  $service_van) {
                      $distance=$this->distance($data->lat,$data->lng,$service_van->latitude,$service_van->longitude,'N');
                    $service_van->distance=round($distance);
              }
             
        }else{
            $service_vans=DB::table('users')->where('id','=',$data->van_id)->where(['role'=>3])->get();
            foreach ($service_vans as  $service_van) {
                      $distance=$this->distance($data->lat,$data->lng,$service_van->latitude,$service_van->longitude,'N');
                    $service_van->distance=round($distance);
              }
        }

        // print_r($service_vans);

       return view('admin.request-carpet-detail',['data'=>$data ,'service_vans'=>$service_vans]);
    }



     public function requestPastCarpetDetail(Request $request)
    {
        $data=DB::table('request_carpets')
            ->leftJoin('users','users.id','=','request_carpets.user_id')
            ->where(['request_carpets.id'=>$request->id])
            ->select('request_carpets.*','users.full_name','users.phone_number','users.email')
            ->first(); 

            // print_r($data); die();

       $get_review= DB::table('carpet_reviews')->where(['carpet_request_id'=>$request->id])->first(); 

       return view('admin.request-past-carpet-detail',['data'=>$data   , 'review'=>$get_review]);
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


    public function acceptCarpetRequest(Request $request)
    {
      
      $update_data['van_id']=$request->van_id;
      $update_data['request_status']=2;
      DB::table('request_carpets')->where(['id'=>$request->request_id])->update($update_data);
      $get_request=DB::table('request_carpets')->where(['id'=>$request->request_id])->first();
     // 4-12-19 $message = "Your service request has been confirmed and scheduled. In the app, this will appear under 'Current' or 'Upcoming' tabs.";
     $message = "Your request for Carpet service has been confirmed and scheduled. On the app, this will appear on ‘Upcoming’.";
      $notfy_key=3;
      $service=$this->getServiceDetail($request->request_id);
      
      $notfy_message = array('sound' =>1,'message'=>$message,'notifykey'=>'3','service_detail'=>$service);
      $get_user=DB::table('users')->where(['id'=>$get_request->user_id])->first();      
      $get_van=DB::table('users')->where(['id'=>$get_request->van_id])->first();      
      
      // $get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
    
      if($get_user->device_type == 'android'){
                 $t = $this->android($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
            }elseif(!empty($get_user->device_token  && $get_user->device_type == 'ios' && strlen($get_user->device_token) > 20 )){
              $this->send_iphone_notification($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
            }

      //notification to van   
    //old message  $van_message='Admin is allocated you a new job.';
      //$van_notfy_message = array('sound' =>1,'message'=>'Admin is allocated you a new job.',
      $van_message='Admin has allocated you a new job for Carpet service. Job Id #'.$get_request->id;
      $van_notfy_message = array('sound' =>1,'message'=>'Admin has allocated you a new job for Carpet service. Job Id #'.$get_request->id,
        'notifykey'=>'1','service_detail'=>$service);
    
      if($get_van->device_type == 'android'){

         $send = $this->android($get_van->device_token,$van_message,$notfy_key,$van_notfy_message,$service);
      }elseif(!empty($get_van->device_token  && $get_van->device_type == 'ios' && strlen($get_van->device_token) > 20 )){
        $this->send_iphone_notification($get_van->device_token,$van_message,$notfy_key,$van_notfy_message,$service);
      }
        $save_notf['user_id']=$get_user->id;
        $save_notf['notification']=$message;
        $save_notf['notification_type']=$notfy_key;
        $save_notf['service_name']=/*$get_service->service_name*/"carpet";
        // $save_notf['service_duration']=$get_service->service_duration;
        $save_notf['carpet_request_id']=$request->request_id;
        $save_notf['created_at']=Date('y-m-d H:i:s');
            
        DB::table('notifications')->insertGetId($save_notf);

        $save_notf['user_id']=$get_van->id;
        $save_notf['notification']=$van_message;
        $save_notf['notification_type']=$notfy_key;
        $save_notf['service_name']=/*$get_service->service_name*/"carpet";
        // $save_notf['service_duration']=$get_service->service_duration;
        $save_notf['carpet_request_id']=$request->request_id;
        $save_notf['created_at']=Date('y-m-d H:i:s');
            
        DB::table('notifications')->insertGetId($save_notf);
       
        Session::flash('message','Carpet service request accepted successfully.');
        return redirect('admin/carpet-new-list');
    }


    public function getServiceDetail($request_id)
    {
           $get_service_requests=DB::table('request_carpets')
            // ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->where(['request_carpets.id'=>$request_id])
            // ->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
            ->first();
       // print_r($get_service_requests);
        return $get_service_requests;
    }



    public function deleteNewCarpetRequest(Request $request){

         $get_request =  DB::table('request_carpets')->where(['id'=>$request->request_id])->first();
            $message='Your Carpet service request was declined.';
            $notfy_key=4;
            $service=$this->getServiceDetail($request->request_id);
          
          $notfy_message = array('sound' =>1,'message'=>'Your Carpet service request was declined.',
          'notifykey'=>'4','service_detail'=>$service);
          $get_user=DB::table('users')->where(['id'=>$get_request->user_id])->first();      
          
          // $get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
          if($get_user->device_type == 'android'){
                     $this->android($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
          }elseif(!empty($get_user->device_token  && $get_user->device_type == 'ios' && strlen($get_user->device_token) > 20 )){
                  $this->send_iphone_notification($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
                }

            $save_notf['user_id']=$get_user->id;
            $save_notf['notification']=$message;
            $save_notf['notification_type']=$notfy_key;
            $save_notf['service_name']=/*$get_service->service_name*/"carpet";
            // $save_notf['service_duration']=$get_service->service_duration;
            $save_notf['carpet_request_id']=$request->request_id;
            $save_notf['created_at']=Date('y-m-d H:i:s');
                
            DB::table('notifications')->insertGetId($save_notf); 


        DB::table('request_carpets')->where(['request_carpets.id'=>$request->request_id])->delete(); 
        DB::table('carpet_reviews')->where(['carpet_request_id'=>$request->request_id])->delete();
        DB::table('carpet_payments')->where(['carpet_request_id'=>$request->request_id])->delete();
        Session::flash('message','Carpet request deleted successfully.');
        return redirect('admin/carpet-new-list');
    }


    public function deletePastCarpetRequest(Request $request){

         $get_request =  DB::table('request_carpets')->where(['id'=>$request->request_id])->first();
            $message='Your Carpet service request was declined.';
            $notfy_key=4;
            $service=$this->getServiceDetail($request->request_id);
          
          $notfy_message = array('sound' =>1,'message'=>'Your Carpet service request was declined.',
          'notifykey'=>'4','service_detail'=>$service);
          $get_user=DB::table('users')->where(['id'=>$get_request->user_id])->first();      
          
          // $get_service=DB::table('services')->where(['id'=>$get_request->service_id])->first();
          if($get_user->device_type == 'android'){
                     $this->android($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
                }elseif(!empty($get_user->device_token  && $get_user->device_type == 'ios' && strlen($get_user->device_token) > 20 )){
                  $this->send_iphone_notification($get_user->device_token,$message,$notfy_key,$notfy_message,$service);
                }

            $save_notf['user_id']=$get_user->id;
            $save_notf['notification']=$message;
            $save_notf['notification_type']=$notfy_key;
            $save_notf['service_name']=/*$get_service->service_name*/"carpet";
            // $save_notf['service_duration']=$get_service->service_duration;
            $save_notf['carpet_request_id']=$request->request_id;
            $save_notf['created_at']=Date('y-m-d H:i:s');
                
            DB::table('notifications')->insertGetId($save_notf); 


        DB::table('request_carpets')->where(['request_carpets.id'=>$request->request_id])->delete(); 
         DB::table('carpet_reviews')->where(['carpet_request_id'=>$request->request_id])->delete();
        DB::table('carpet_payments')->where(['carpet_request_id'=>$request->request_id])->delete();
        Session::flash('message','Carpet request deleted successfully.');
        return redirect('admin/carpet-past-list');
    }


     public function android($device_token,$message,$notmessage='',$sender_id='',$data_message) 
    {

       // $API_ACCESS_KEY = 'AAAAfm9V_oY:APA91bEliyt5maUVB29kDWqm_EKkmwCJWqHMW5aTSth31pehvu5Q1McB_2Z8BraX2jcMcJgKYJJSzMm5S__eYgAKM2813r9DqrzLFJGWy6jkKh04rMDEhVJlXqSqtw3r4nH-Hl0tXCIT';

      $API_ACCESS_KEY = 'AAAA5Htr6lQ:APA91bGrvo0Dfa6wozDLBv5oURc-ILrhEut45_0w8sd_x3avhL_e6Avkrwrpqc1b4gdmR2TpXPdo10faAIAusOjlISclsWuwLXvx2X7gDeqqf2WngUZScQjLiPlfRggjnYGbhsNo4C9R';
       
        $registrationIds = $device_token;
         $msg = array( 
                'title' => "PreshaWash",
                'body'  => $message
         );
        
         $details = array('Notifykey' => $notmessage, 
                    'msgsender_id'=>$sender_id,
                    'service_detail' => $data_message,
                    );
        $fields = array(
            'to'=> $registrationIds,
            'notification'  => $msg,
            'data'  => ($details),
            
        );

        $headers = array(
                    'Authorization: key=' . $API_ACCESS_KEY,
                    'Content-Type: application/json'
                );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

        $result = curl_exec($ch );
        curl_close( $ch );
    }
    
    // public function send_iphone_notification($receiver_id,$message,$notmessage='',$sender_id, $data_message)
    // {  

    //         $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PushCertificates.pem";
          
    //         $deviceToken = $receiver_id;
    //         $passphrase = "";
    //         $message = $message;
            
    //         $ctx = stream_context_create();
    //                stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
    //                stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        
    //         $fp = stream_socket_client(
    //                                   'ssl://gateway.sandbox.push.apple.com:2195', $err,
    //            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
               
    //          // $fp = stream_socket_client(
    //          //                            'ssl://gateway.push.apple.com:2195', $err,
    //          //    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
                
    //         $body['message'] = $message;
    //         $body['service_detail'] = $data_message;
    //         $body['Notifykey'] = $notmessage;
    //         //$body['ServiceDetail'] = $ServiceDetail;
             
    //         if (!$fp)
    //              exit("Failed to connect: $err $errstr" . PHP_EOL);

    //         $body['aps'] = array(
    //             'alert' => $message,
    //             'sound' => 'default',
    //             'details'=>$body
    //         );
            

    //         $payload = json_encode($body);
    //         $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    //         $result = fwrite($fp, $msg, strlen($msg));

    //         fclose($fp);
              
    //     } 
    public function send_iphone_notification($receiver_id,$message,$notmessage='',$sender_id, $data_message) 
    {

        $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PushCertificates.pem";
        $deviceToken = $receiver_id;  
        $passphrase = "123456";
        $ctx = stream_context_create();
             stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
             stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        
        // $fp = stream_socket_client(
        //             'ssl://gateway.sandbox.push.apple.com:2195', $err,
        // $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 

          $fp = stream_socket_client(
                     'ssl://gateway.push.apple.com:2195', $err,
          $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 

     /* $body['message'] = $message;
      $body['service_id'] = $notfy_message;
      $body['Notifykey'] = $notmessage;
      //$body['service_id'] = $service_id;*/

            $body['message'] = $message;
            $body['service_detail'] = $data_message;
            $body['Notifykey'] = $notmessage;
            //$body['ServiceDetail'] = $ServiceDetail;

       
      // if (!$fp)
      //      exit("Failed to connect: $err $errstr" . PHP_EOL);

      // $body['aps'] = array(
      //     'alert' => $message,
      //     'sound' => 'default',
      //     'details' => $body
      // );
            if (!$fp)
                 exit("Failed to connect: $err $errstr" . PHP_EOL);

            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default',
                'details'=>$body
            );


        $pem_file       = $PATH;
        $pem_secret     = '123456';
        $apns_topic     = 'com.waterworks';

        $sample_alert = json_encode($body);
        $url = "https://api.development.push.apple.com/3/device/$deviceToken";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sample_alert);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("apns-topic: $apns_topic"));
        curl_setopt($ch, CURLOPT_SSLCERT, $pem_file);
        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $pem_secret);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // return "success"; die();
    }



    public function carpetPaymentListing(Request $request)
    {
        $request_list=DB::table('request_carpets')
            ->leftJoin('users','users.id','=','request_carpets.user_id')
            // ->leftJoin('services','services.id','=','requests.service_id')
            // ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->select('users.*','request_carpets.id as request_id')
            ->orderBy('request_carpets.id','Desc')
            ->get(); 

        $payments =DB::table('carpet_payments')->orderBy("id" , "Desc")->get(); 
        foreach ($payments as $payment) {
            $payment->request_detail=DB::table('request_carpets')
            ->leftJoin('users','users.id','=','request_carpets.user_id')
            ->orderBy('request_carpets.id','Desc')
            ->where('request_carpets.id',$payment->carpet_request_id)
            ->first(); 
        }
        //echo "<pre>";print_r($payments);die;
        return view('admin.carpet_payment_list',['payments'=>$payments]);
    }


    public function carpetPaymentDetail(Request $request)
    {
         $payment = DB::table('carpet_payments')->where(['id'=>$request->id])->first();

         $payment_detail=DB::table('request_carpets')
            ->leftJoin('users','users.id','=','request_carpets.user_id')
            // ->leftJoin('reviews','reviews.request_id','=','requests.id')
            ->where(['request_carpets.id'=>$payment->carpet_request_id])
            ->first();  
            //echo "<pre>";print_r($payment_detail);die;
        return view('admin.carpet_payment_detail',['request'=>$payment_detail,'payment'=>$payment]);
    }




    public function carpetReviewsListing(Request $request)
    {
     $get_reviews=DB::table('carpet_reviews')
      //  ->select('')
           ->leftJoin('users','users.id','=','carpet_reviews.user_id') 
           ->leftJoin('request_carpets','request_carpets.id','=','carpet_reviews.carpet_request_id')
           // ->select('users.*','carpet_reviews.*','carpet_reviews.id as review_id','request_carpets.*','request_carpets.id as request_id')
           ->orderby('carpet_reviews.id','Desc')
           ->get();
      //echo "<pre>";print_r($get_reviews);die;

           // print_r($get_reviews);
        return view('admin.carpet_reviews',['reviews'=>$get_reviews]);
    }
    
    public function carpetReviewDetail(Request $request,$request_id)
    {
       
        $review_detail=DB::table('request_carpets')
            ->leftJoin('users','users.id','=','request_carpets.user_id')
            // ->leftJoin('services','services.id','=','requests.service_id')
            // ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->leftJoin('carpet_reviews','carpet_reviews.carpet_request_id','=','request_carpets.id')
           ->where(['request_carpets.id'=>$request_id])
             // ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id','reviews.*')
            ->first();
     // echo "<pre>";phprint_r($review_detail);die;
        return view('admin.carpet-review-detail',['request'=>$review_detail]);

    }



    public function carpetMeasurement(Request $request){
        if($request->isMethod("GET")){
            return view ("admin/carpet_measurement");
        }

        if($request->isMethod("post")){
          
          $errors = array(
            'height.required'=>'Please enter carpet length.',
            'height.numeric'=>'Please enter numeric value only.',
            'height.min'=>'Carpet Length should be greater than or equal to 1.',
            'width.required'=>'Please enter carpet width.',
            'width.numeric'=>'Please enter numeric value only.',
            'width.min'=>'Carpet Width should be greater than or equal to 1.',
            

            );
            $validator = Validator::make($request->all(), [
             'height'  => 'required|numeric|min:1',
             'width' => 'required|numeric|min:1',

            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $data = [ 
                "height" => $request->height,
                "width" => $request->width,

            ];

            $is_created = CarpetMeasurement::create($data);

              if($is_created){
                  return redirect(url("admin/carpet-measurement"))->with("message" , "Carpet measurement added successfully.");
              }else{
                  return back()->with("error" , "Unable to add Measurement.");
              }
          }

    }


    public function carpetMeasurementList(Request $request){
      $data = CarpetMeasurement::orderBy("id" ,"Desc")->get();
      return view("admin/carpet_measurement_list" , ["data" => $data]);
    }


    public function deleteCarpetMeasurement(Request $request ){
      $is_deleted =  DB::table('carpet_measurements')->where("id" , $request->id)->delete(); 
      // $is_deleted = CarpetMeasurement::where("id" , $request->id)->delete();
      if($is_deleted){
        return redirect(url("admin/carpet-measurement-list"))->with("message" , "Carpet measurement deleted successfully.");
      }else{
        return back()->with("error" , "Unable to processed");
      }
    }


    public function editCarpetMeasurements(Request $request , $id){
        if($request->isMethod("GET")){
          $data = CarpetMeasurement::where("id",$id)->first();
           return view("admin/edit-carpet-measurements" , ["data"=>$data]);
        }
        if($request->isMethod("POST")){

          $errors = array(
            'height.required'=>'Please enter carpet length.',
            'height.numeric'=>'Please enter numeric value only.',
            'height.min'=>'Carpet Length should be greater than or equal to 1.',
            'width.required'=>'Please enter carpet width.',
            'width.numeric'=>'Please enter numeric value only.',
            'width.min'=>'Carpet Width should be greater than or equal to 1.',
            );
            $validator = Validator::make($request->all(), [
             'height'  => 'required|numeric|min:1',
             'width' => 'required|numeric|min:1',

            ],$errors);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $data = [ 
                "height" => $request->height,
                "width" => $request->width,
            ];

            $is_updated = CarpetMeasurement::where("id",$id)->update($data);

            if($is_updated){
                return redirect(url("admin/carpet-measurement-list"))->with("message","Carpet measurement updated successfully.");
            }else{
                return back()->with("error" ,"Unable to edit carpet measurement.");
            }
        }
    }


}
