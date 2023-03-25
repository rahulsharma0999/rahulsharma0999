  <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('public/admin/production/images/apple-icon.png')}}" />
    <link rel="icon" type="image/png" href="{{url('admin/assets/img/favicon1.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Contact Us</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <style type="text/css">
      table tr td {
        font-size:20px;
        font-weight: bold;
        margin-bottom: 15px;
      }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<?php 

error_reporting(0);
?>
<body>
  <div class="col-sm-3"></div>
  <div class="col-sm-6" style="background:#efefef;margin-top:70px;padding:0">
    <div class="col-sm-12 text-center" style="margin-bottom: 30px;padding-top:20px;text-align: center;">
      <img src="{{$message->embed($logo)}}" alt="" width="115px"/>
    </div>
    <div style="width: 100%;background-color: black;height: 1px;margin-bottom: 10px;" class="col-sm-12"></div>
    
    <h1 class="text-center" style="text-align: center; font-weight: bold; font-size: 20px;">
      Contact Us
    </h1>
    <div class="col-sm-12" style="padding: 0 82px;">
      Hello Admin,<br><br>You have received a Contact Us request
      <div style="margin-bottom: 15px;"></div>
      <p><strong>Name</strong> : {{$name}}</p><p><strong>Email</strong> : {{$email}}</p><p><strong>Message</strong> : {{$message_send}}</p>
    </div>
    <div class="col-sm-12" style="margin-top: 20px;background-color: #727272;padding:15px;text-align: center;">
        <div style="font-family:arial, sans-serif;">© PreshaWash {{date('Y')}}</div>
    </div>
  </div>
<div style="clear: both"></div>
</body>
</html>
