<html>
<head>
  <link rel="icon" type="image/png" sizes="96x96" href="{{url('admin/assets/img/favicon1.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
.temp123
{
margin: 0 auto;
margin-left: auto;
margin-right: auto;
text-align:center;
}
</style>
</head>
<body style="font-family:'Times New Roman';font-size:15px"><div style="margin-bottom: 20px;text-align: center;"><img src="{{ url('admin/assets/img/logo-2.png') }}" alt="" height="170" width="170"/>
</div><p style="Margin-top:5px;Margin-bottom:10px">Hello <?php if(!empty($user_data->full_name)) echo $user_data->full_name; else echo 'User'; ?>,</p>
<p style="Margin-bottom: 15px;"><p>Thank you for downloading our application, please verify your email address. </p>		<p style="Margin-bottom:10px;"><a href="{{ $url }}"> Click here to verify your email</a></p>	
<p style="Margin-bottom:10px;">Best Regards, <br/>Your Friends at PreshaWash</p></body>
</html>