<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationCustomClass extends Controller
{
    
	public static function send_iphone_notification($recivertok_id,$message,$notmessage='',$data=''){
		//$PATH = dirname(dirname(dirname(dirname(__FILE__))))."/pemfile/lens_development_push.pem";
		 $PATH = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/pemfile/PushCertificates.pem";
		$deviceToken = $recivertok_id;  
		$passphrase = "";
		$message = $message;  
		$ctx = stream_context_create();
			   stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
			   stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		
	 //  	$fp = stream_socket_client(
		// 						'ssl://gateway.sandbox.push.apple.com:2195', $err,
		// $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
		   
	   $fp = stream_socket_client(
								 'ssl://gateway.push.apple.com:2195', $err,
		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
		  
	 	$body['message'] = $message;
     	$body['details'] = $data;
 		$body['Notifykey'] = $notmessage;
            if (!$fp)
                 exit("Failed to connect: $err $errstr" . PHP_EOL);

        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'default',
            'details'=>$body
        );
           
		$payload = json_encode($body);
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		$result = fwrite($fp, $msg, strlen($msg));

		//echo "<pre>";
		// print_r($result);
		// if (!$result)
			// echo 'Message not delivered' . PHP_EOL;
		// else
			// echo 'Message successfully delivered' . PHP_EOL;
		// exit;
		fclose($fp);
		return $result;
		die;
	}
	
	public static function send_iphone_notification_hidden($recivertok_id,$message,$notmessage='',$msgsender_id=''){
		/*$PATH = dirname(dirname(dirname(dirname(__FILE__))))."/pemfile/KevinPushCertificates.pem";*/
		$PATH = dirname(dirname(dirname(dirname(__FILE__))))."/pemfile/PushCertificates.pem";
		//print $PATH;die;
		$deviceToken = $recivertok_id;
		$passphrase = "";
		$message = $message;
		$ctx = stream_context_create();
			   stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
			   stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		
		$fp = stream_socket_client(  
					'ssl://gateway.sandbox.push.apple.com:2195', $err,
		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
		
		if (!$fp)
		 	exit("Failed to connect: $err $errstr" . PHP_EOL);
			$body['aps'] = array(
				//'alert' => $message,
				//'sound' => 'default',
				//'Notifykey' => $notmessage, 
				'msgsender_id'=>$msgsender_id, 
				'content-available'=>1
			);

		$payload = json_encode($body);
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		$result = fwrite($fp, $msg, strlen($msg));
         
		// echo "<pre>";
		// print_r($result);die;
	     // if (!$result)
			 // echo 'Message not delivered' . PHP_EOL;
		 // else
			 // echo 'Message successfully delivered' . PHP_EOL;
		 // exit;
		fclose($fp);
		return  $result;
	}
		
		
	function send_android_notification($device_token,$message,$notmessage='',$msgsender_id=''){
		if (!defined('API_ACCESS_KEY'))
		{
			define('API_ACCESS_KEY','AIzaSyC33d4ZB4FBJ_h0jHU5qEzY4FFJFNRjTzA');
		}
		$registrationIds = array($device_token);
		$fields = array(
			'registration_ids' => $registrationIds,
			'alert' => $message,
			'sound' => 'default',
			'Notifykey' => $notmessage, 
			'data'=>$msgsender_id
				
		);
		$headers = array(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
		$result = curl_exec($ch);

		if($result == FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}

		curl_close( $ch );
		return  $result;
	}

	public function android($device_token,$message,$notmessage='',$sender_id='',$data_message = array()) 
	{
	    #API access key from Google API's Console
	   //define('API_ACCESS_KEY', '');
	  /* $API_ACCESS_KEY = 'AAAA7IHBM5o:APA91bHmFRX1Xdpfp6f-YO9sqSwrtFSH1qj2hX0U7NbUORp97HVcpX_3MiiMV3QXE_dKzWsvli_9RrQ4YUKBM0KBnzNTQHFRheqB7-0GHtM51A5BYfeWpAg0LfylyISFsVFZwOAXztSuHx3GeXAJ2e3vDTrXBw5Zjg';*/

	   $API_ACCESS_KEY = 'AAAA5Htr6lQ:APA91bHSEJC1QX2gMwfHUQK3-xufV4lya7pZd_6RUqmOKrWbkPEeBHyJKo0SeLX2Ee7z0V8LpwJQMudfnZAyAfsz3uLLDJqRBcnnearx2JqBd3k-cvSG9EkfVtt0S_5JQL-8fjmiO-_n';
	    $registrationIds = $device_token;
	    #prep the bundle
	     $msg = array( 
                'title' => "Water work",
                'body'  => $message
	                // 'icon'   => 'default',/*Default Icon*/
	                //  'sound' => 'default',/*Default sound*/
	                //'data'    => $details
	     );

	     $details = array('Notifykey' => $notmessage, 
					'msgsender_id'=>$sender_id,
					'data_message' => $data_message
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
}
