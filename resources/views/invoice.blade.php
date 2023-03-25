

<body style="font-family:'Times New Roman';font-size:15px">
<div style="margin-bottom: 20px;text-align: center;">
	<img src="{{ url('admin/assets/img/logo-2.png') }}" alt="Water-works" height="170" width="170"/>
	
</div>
	<div>
	<?php
	
	$invoice_num = $invoice_id;
	 $invoice_date = $due_date = date("F d, Y");
	?>
 		<p style="Margin-top:5px;Margin-bottom:10px">Hello <?php if(!empty($user_data->full_name)) echo $user_data->full_name; else echo 'User'; ?>,</p>
		<p style="Margin-bottom: 15px;">
			This is a notice that invoice no <?php echo $invoice_num; ?>  has been generated <?php echo $invoice_date;?>.
		</p>

		<p style="Margin-bottom:10px;">Best Regards, <br/>
		Your Friends at PreshaWash
		</p>	
	</div>
</body>
		
