

<body style="font-family:'Times New Roman';font-size:15px">
<div style="margin-bottom: 20px;text-align: center;">
	<img src="{{$message->embed($logo)}}" alt="Water-works" height="170" width="170"/>
	
</div>
	<div>
 		<p style="Margin-top:5px;Margin-bottom:10px">Hello <?php if(!empty($user_data->full_name)) echo $user_data->full_name; else echo'User'; ?>,</p>
		<p style="Margin-bottom: 15px;">
		<p>We have received your request to reset password. In order to proceed with this request, Please follow the link below: </p>
		<p style="Margin-bottom:10px;"><a href="{{ $url }}"> Click here for reset your password</a></p>
		  Or copy and paste below given url:<br/> 
	     {{ $url }} <br/>
		<p style="Margin-bottom:10px;">If you don’t want to reset your password, you can ignore this email.</p>
		<p style="Margin-bottom:10px;">If you did not request this change, you may want to review your security settings or contact us for assistance.</p>

		<p style="Margin-bottom:10px;">Best Regards, <br/>
		Your Friends at PreshaWash
		</p>	
	</div>
</body>
		
