<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\UpholsteryService;
use App\UpholsteryCouches;
use App\UpholsteryDinningChairs;
use App\UpholsterySideChairs;

use Validator;
use Session;


class UpholsteryController extends Controller
{
    public function upholsteryService(Request $request){
    	if($request->isMethod("GET")){
        	$data = UpholsteryService::all()->first();
            return view ("admin/upholstery_service" , ["data"=>$data]);
        }

        if($request->isMethod("post")){
        	
        	$errors = array(
            'couche.required'=>'Please enter couches price.',
            'couche.numeric'=>'Please enter numeric value only.',
            'couche.min'=>'Price should be greater than or equal to 1.',
            'dinning_chair.required'=>'Please enter dinning chair price.',
            'dinning_chair.numeric'=>'Please enter numeric value only.',
            'dinning_chair.min'=>'Price should be greater than or equal to 1.',
            'side_chair.required'=>'Please enter side chair price.',
            'side_chair.numeric'=>'Please enter numeric value only.',
            'side_chair.min'=>'Price should be greater than or equal to 1.',

            );
            $validator = Validator::make($request->all(), [
             'couche'  => 'required|numeric|min:1',
             'dinning_chair' => 'required|numeric|min:1',
             'side_chair'    => 'required|numeric|min:1',

            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $data = [ 
                "couche_price" => $request->couche,
                "dinning_chair_price" => $request->dinning_chair,
                "side_chair_price" => $request->side_chair,

            ];

	        $checkdata = UpholsteryService::count();
	        $details = UpholsteryService::all()->first();
	            if($checkdata == 0){
	                $is_created = UpholsteryService::create($data);  
	                return redirect(url("admin/upholstery-service"))->with("message" , "Price added successfully.");
	            }else{
	                $is_updated = UpholsteryService::where("id" , $details->id)->update($data);
	                return redirect(url("admin/upholstery-service"))->with("message" , "Price updated successfully.");
	            }
   		}

   	}



   	public function upholsteryNewList(Request $request)
    {
        $data = DB::table('request_upholsterys')
                        ->leftJoin('users','request_upholsterys.user_id','=','users.id')
                        ->Where('request_upholsterys.request_status','!=',3)
                        ->Where('request_upholsterys.final_status','=',1)
                        ->select('request_upholsterys.*','users.full_name','users.phone_number','users.email')
                        ->orderBy('request_upholsterys.id' , 'Desc')
                        ->get(); 

        // return $data;

        return view('admin.upholstery_new_request_list',['data'=>$data]);
    }


    public function upholsteryPastList(Request $request)
    {
        $data = DB::table('request_upholsterys')
                        ->leftJoin('users','request_upholsterys.user_id','=','users.id')
                        ->Where('request_upholsterys.request_status','!=',3)
                        ->Where('request_upholsterys.final_status','=',2)
                        ->select('request_upholsterys.*','users.full_name','users.phone_number','users.email')
                        ->orderBy('request_upholsterys.id' , 'Desc')
                        ->get(); 

        return view('admin.upholstery_past_request_list',['data'=>$data]);
    }



    public function requesNewUpholsteryDetail(Request $request)
    {
        $data=DB::table('request_upholsterys')
            ->leftJoin('users','users.id','=','request_upholsterys.user_id')
            ->where(['request_upholsterys.id'=>$request->id])
            ->select('request_upholsterys.*','users.full_name','users.phone_number','users.email')
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

       return view('admin.upholstery_new_request_detail',['data'=>$data ,'service_vans'=>$service_vans]);
    }



     public function requestPastUpholsteryDetail(Request $request)
    {
        $data=DB::table('request_upholsterys')
            ->leftJoin('users','users.id','=','request_upholsterys.user_id')
            ->where(['request_upholsterys.id'=>$request->id])
            ->select('request_upholsterys.*','users.full_name','users.phone_number','users.email')
            ->first(); 


        $get_review= DB::table('upholstery_reviews')->where(['upholstery_request_id'=>$request->id])->first(); 

       return view('admin.upholstery_past_request_detail',['data'=>$data ,'review'=>$get_review]);
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


    public function acceptUpholsteryRequest(Request $request)
    {
      
      $update_data['van_id']=$request->van_id;
      $update_data['request_status']=2;
      DB::table('request_upholsterys')->where(['id'=>$request->request_id])->update($update_data);
      $get_request=DB::table('request_upholsterys')->where(['id'=>$request->request_id])->first();
     // 4-12-19 $message = "Your service request has been confirmed and scheduled. In the app, this will appear under 'Current' or 'Upcoming' tabs.";
     $message = "Your request for Upholstery service has been confirmed and scheduled. On the app, this will appear on ‘Upcoming’.";
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
      $van_message='Admin has allocated you a new job for Upholstery service. Job Id #'.$get_request->id;
      $van_notfy_message = array('sound' =>1,'message'=>'Admin has allocated you a new job for Upholstery service. Job Id #'.$get_request->id,
        'notifykey'=>'1','service_detail'=>$service);
    
      if($get_van->device_type == 'android'){

         $send = $this->android($get_van->device_token,$van_message,$notfy_key,$van_notfy_message,$service);
      }elseif(!empty($get_van->device_token  && $get_van->device_type == 'ios' && strlen($get_van->device_token) > 20 )){
        $this->send_iphone_notification($get_van->device_token,$van_message,$notfy_key,$van_notfy_message,$service);
      }
        $save_notf['user_id']=$get_user->id;
        $save_notf['notification']=$message;
        $save_notf['notification_type']=$notfy_key;
        $save_notf['service_name']=/*$get_service->service_name*/"upholstery";
        // $save_notf['service_duration']=$get_service->service_duration;
        $save_notf['upholstery_request_id']=$request->request_id;
        $save_notf['created_at']=Date('y-m-d H:i:s');
            
        DB::table('notifications')->insertGetId($save_notf);

        $save_notf['user_id']=$get_van->id;
        $save_notf['notification']=$van_message;
        $save_notf['notification_type']=$notfy_key;
        $save_notf['service_name']=/*$get_service->service_name*/"upholstery";
        // $save_notf['service_duration']=$get_service->service_duration;
        $save_notf['upholstery_request_id']=$request->request_id;
        $save_notf['created_at']=Date('y-m-d H:i:s');
            
        DB::table('notifications')->insertGetId($save_notf);
       
        Session::flash('message','Upholstery service request accepted successfully.');
        return redirect('admin/upholstery-new-list');
    }



    public function getServiceDetail($request_id)
    {
           $get_service_requests=DB::table('request_upholsterys')
            // ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->where(['request_upholsterys.id'=>$request_id])
            // ->select('requests.id as sevice_id','vehicles.name as vehicle_name','requests.service_duration as job_duration','requests.total_price as job_price','requests.service_date','requests.service_time','requests.created_at','requests.updated_at')
            ->first();
       // print_r($get_service_requests);
        return $get_service_requests;
    }


    public function deleteNewUpholsteryRequest(Request $request){

         $get_request =  DB::table('request_upholsterys')->where(['id'=>$request->request_id])->first();
            $message='Your Upholstery service request was declined.';
            $notfy_key=4;
            $service=$this->getServiceDetail($request->request_id);
          
          $notfy_message = array('sound' =>1,'message'=>'Your Upholstery service request was declined.',
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
            $save_notf['service_name']=/*$get_service->service_name*/"upholstery";
            // $save_notf['service_duration']=$get_service->service_duration;
            $save_notf['upholstery_request_id']=$request->request_id;
            $save_notf['created_at']=Date('y-m-d H:i:s');
                
            DB::table('notifications')->insertGetId($save_notf); 


        DB::table('request_upholsterys')->where(['request_upholsterys.id'=>$request->request_id])->delete();
        DB::table('upholstery_reviews')->where(['upholstery_request_id'=>$request->request_id])->delete();
        DB::table('upholstery_payments')->where(['upholstery_request_id'=>$request->request_id])->delete();

        Session::flash('message','Upholstery request deleted successfully.');
        return redirect('admin/upholstery-new-list');
    }


    public function deletePastUpholsteryRequest(Request $request){

         $get_request =  DB::table('request_upholsterys')->where(['id'=>$request->request_id])->first();
            $message='Your Upholstery service request was declined.';
            $notfy_key=4;
            $service=$this->getServiceDetail($request->request_id);
          
          $notfy_message = array('sound' =>1,'message'=>'Your Upholstery service request was declined.',
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
            $save_notf['service_name']=/*$get_service->service_name*/"upholstery";
            // $save_notf['service_duration']=$get_service->service_duration;
            $save_notf['upholstery_request_id']=$request->request_id;
            $save_notf['created_at']=Date('y-m-d H:i:s');
                
            DB::table('notifications')->insertGetId($save_notf); 


        DB::table('request_upholsterys')->where(['request_upholsterys.id'=>$request->request_id])->delete();
        DB::table('upholstery_reviews')->where(['upholstery_request_id'=>$request->request_id])->delete();
        DB::table('upholstery_payments')->where(['upholstery_request_id'=>$request->request_id])->delete();

        Session::flash('message','Upholstery request deleted successfully.');
        return redirect('admin/upholstery-past-list');
    }



    public function android($device_token,$message,$notmessage='',$sender_id='',$data_message) 
    {

       // $API_ACCESS_KEY = 'AAAA5Htr6lQ:APA91bHSEJC1QX2gMwfHUQK3-xufV4lya7pZd_6RUqmOKrWbkPEeBHyJKo0SeLX2Ee7z0V8LpwJQMudfnZAyAfsz3uLLDJqRBcnnearx2JqBd3k-cvSG9EkfVtt0S_5JQL-8fjmiO-_n';
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
    




    public function upholsteryPaymentListing(Request $request)
    {
        $request_list=DB::table('request_upholsterys')
            ->leftJoin('users','users.id','=','request_upholsterys.user_id')
            // ->leftJoin('services','services.id','=','requests.service_id')
            // ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->select('users.*','request_upholsterys.id as request_id')
            ->orderBy('request_upholsterys.id','Desc')
            ->get(); 

        $payments =DB::table('upholstery_payments')->orderBy("id" , "Desc")->get(); 
        foreach ($payments as $payment) {
            $payment->request_detail=DB::table('request_upholsterys')
            ->leftJoin('users','users.id','=','request_upholsterys.user_id')
            ->orderBy('request_upholsterys.id','Desc')
            ->where('request_upholsterys.id',$payment->upholstery_request_id)
            ->first(); 
        }
        //echo "<pre>";print_r($payments);die;
        return view('admin.upholstery_payment',['payments'=>$payments]);
    }


    public function upholsteryPaymentDetail(Request $request)
    {
         $payment = DB::table('upholstery_payments')->where(['id'=>$request->id])->first();

         $payment_detail=DB::table('request_upholsterys')
            ->leftJoin('users','users.id','=','request_upholsterys.user_id')
            // ->leftJoin('reviews','reviews.request_id','=','requests.id')
            ->where(['request_upholsterys.id'=>$payment->upholstery_request_id])
            ->first();  
            // echo "<pre>";print_r($upholstery_payment_detail detail);die;
        return view('admin.upholstery_payment_detail',['request'=>$payment_detail,'payment'=>$payment]);
    }




    public function upholsteryReviewsListing(Request $request)
    {
     $get_reviews=DB::table('upholstery_reviews')
      //  ->select('')
           ->leftJoin('users','users.id','=','upholstery_reviews.user_id') 
           ->leftJoin('request_upholsterys','request_upholsterys.id','=','upholstery_reviews.upholstery_request_id')
           ->orderby('upholstery_reviews.id','Desc')
           ->get();

           // print_r($get_reviews);
        return view('admin.upholstery_review',['reviews'=>$get_reviews]);
    }
    
    public function upholsteryReviewDetail(Request $request,$request_id)
    {
       
        $review_detail=DB::table('request_upholsterys')
            ->leftJoin('users','users.id','=','request_upholsterys.user_id')
            ->leftJoin('upholstery_reviews','upholstery_reviews.upholstery_request_id','=','request_upholsterys.id')
           ->where(['request_upholsterys.id'=>$request_id])
            ->first();
     // echo "<pre>";print_r($review_detail);die;
        return view('admin.upholstery_review_detail',['request'=>$review_detail]);

    }

    public function addUpholsteryCouches(Request $request){
        if($request->isMethod("GET")){
          $data = UpholsteryCouches::orderBy("id" , "Desc")->get();
            return view ("admin/upholstery_couches" , ["data"=>$data]);
        }

        if($request->isMethod("post")){
          
          $errors = array(
            'couche.required'=>'Please enter Couches.',
            'couche.numeric'=>'Please enter numeric value only.',
            'couche.min'=>'Couche should be greater than 0.',

            // 'dinning_chair.numeric'=>'Please enter numeric value only.',
            // 'dinning_chair.min'=>'Dinning chair should be greater than 0.',
            
            // 'side_chair.numeric'=>'Please enter numeric value only.',
            // 'side_chair.min'=>'Side chair should be greater than 0.',

            );
            $validator = Validator::make($request->all(), [
             'couche'  => 'required|numeric|min:1',

            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

                $couche = [ 
                    "no_of_couches" => $request->couche,
                ];
                $is_created = UpholsteryCouches::create($couche);
              
                if($is_created){
                  return redirect(url("admin/upholstery-couches"))->with("message" , "Couches added successfully.");
                }else{
                  return back()->with("message" , "Unable to processed.");
                }
          }
      }


      public function addUpholsteryDinningChair(Request $request){
        if($request->isMethod("GET")){
          $data = UpholsteryDinningChairs::orderBy("id" , "Desc")->get();
            return view ("admin/upholstery_dinning_chair" , ["data" => $data]);
        }

        if($request->isMethod("post")){
          
          $errors = array(
            'dinning_chair.required'=>'Please enter Dinning chairs.',
            'dinning_chair.numeric'=>'Please enter numeric value only.',
            'dinning_chair.min'=>'Dinning chair should be greater than 0.',

            );
            $validator = Validator::make($request->all(), [
             'dinning_chair' => 'required|numeric|min:1',

            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

                $data = [ 
                    "no_of_dinning_chairs" => $request->dinning_chair,
                ];
                $is_created = UpholsteryDinningChairs::create($data);
              
                if($is_created){
                  return redirect(url("admin/upholstery-dinning-chair"))->with("message" , "Dinning chairs added successfully.");
                }else{
                  return back()->with("message" , "Unable to processed.");
                }
          }
      }


      public function addUpholsterySideChair(Request $request){
        if($request->isMethod("GET")){
          $data = UpholsterySideChairs::orderBy("id" , "Desc")->get();
            return view ("admin/upholstery_side_chair" , ["data" => $data]);
        }

        if($request->isMethod("post")){
          
          $errors = array(
            'side_chair.required'=>'Please enter Side chairs.',
            'side_chair.numeric'=>'Please enter numeric value only.',
            'side_chair.min'=>'Side chair should be greater than 0.',

            );
            $validator = Validator::make($request->all(), [
             'side_chair' => 'required|numeric|min:1',

            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

                $data = [ 
                    "no_of_side_chairs" => $request->side_chair,
                ];
                $is_created = UpholsterySideChairs::create($data);
              
                if($is_created){
                  return redirect(url("admin/upholstery-side-chair"))->with("message" , "Side chairs added successfully.");
                }else{
                  return back()->with("message" , "Unable to processed.");
                }
          }
      }



        public function deleteCouches(Request $request ){
          $is_deleted =  DB::table('upholstery_couches')->where("id" , $request->id)->delete(); 
          if($is_deleted){
            return redirect(url("admin/upholstery-couches"))->with("messages" , "Couches deleted successfully.");
          }else{
            return back()->with("error" , "Unable to processed");
          }
        }

        public function deleteDinningChair(Request $request ){
          $is_deleted =  DB::table('upholstery_dinning_chairs')->where("id" , $request->id)->delete(); 
          if($is_deleted){
            return redirect(url("admin/upholstery-dinning-chair"))->with("messages" , "Dinning chairs deleted successfully.");
          }else{
            return back()->with("error" , "Unable to processed");
          }
        }

        public function deleteSideChair(Request $request ){
          $is_deleted =  DB::table('upholstery_side_chairs')->where("id" , $request->id)->delete(); 
          if($is_deleted){
            return redirect(url("admin/upholstery-side-chair"))->with("messages" , "Side chairs deleted successfully.");
          }else{
            return back()->with("error" , "Unable to processed");
          }
        }


}
