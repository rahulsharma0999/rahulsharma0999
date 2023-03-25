
<div style="margin-bottom: 20px;text-align: center;">
	<img src="{{ url('img/1024.png') }}" alt="Legasi" height="150" width="150"/>
</div>
<p style="margin-top:10px;margin-bottom:10px"><h2>Bank Of Ideas User Detail</h2></p>
<p style="margin-top:10px;margin-bottom:10px"><b>Name: </b> @if(!empty($getData->name)) {{$getData->name}} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>Email: </b> @if(!empty($getData->email)) {{ $getData->email }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>PhoneNumber: </b> @if(!empty($getData->mobile_number)) {{ $getData->mobile_number }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b> Nationality: </b> @if(!empty($getData->nationality)) {{ $getData->nationality }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>City:</b> @if(!empty($getData->city)) {{ $getData->city }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>Dob :</b> @if(!empty($getData->dob)){{ $getData->dob }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>occupation: </b> @if(!empty($getData->occupation))  {{ $getData->occupation }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>Comment: </b> @if(!empty($getData->comment))  {{ $getData->comment }} @else N/A @endif</p>
<p style="margin-top:10px;margin-bottom:10px"><b>Image: </b> @if(!empty($getData->mediaUrl)) <br/> <img src="<?php echo $getData->mediaUrl; ?>" width="300px" height="100px" > @else N/A @endif</p>

