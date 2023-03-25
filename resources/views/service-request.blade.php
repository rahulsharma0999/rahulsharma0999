<body style="font-family:'Times New Roman';font-size:15px">
<div style="margin-bottom: 20px;text-align: center;">
	<img src="{{$message->embed($logo)}}" alt="Water-works" height="170" width="170"/>
	
</div>
	<div>
 		<p style="Margin-top:5px;Margin-bottom:10px">Hello Admin,</p>
		<p style="Margin-bottom: 15px;">
		<p>Preshawash just received a new <?php echo($item_type) ?> service request.</p> 
		<p style="Margin-bottom:10px;"><b>User Name</b> : <?php if(!empty($user_data->full_name)) echo $user_data->full_name; else echo'N/A'; ?>.</p>
		<p style="Margin-bottom:10px;"><b>Email Address</b> : <?php if(!empty($user_data->email)) echo $user_data->email; else echo'N/A'; ?>.</p>
	</div>
</body>
		

