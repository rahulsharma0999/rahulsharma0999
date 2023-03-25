<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('admin/img/favicon.png')}}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Paper Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{asset('admin/css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{asset('admin/css/paper-dashboard.css')}}" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('admin/css/demo.css')}}" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{asset('admin/css/themify-icons.css')}}" rel="stylesheet">
	<!-- custom style -->
    <link href="{{asset('admin/css/custom-style.css')}}" rel="stylesheet">
	<link href="{{asset('admin/css/responsive.css')}}" rel="stylesheet">

</head>
<body>

<div class="wrapper login-page full-screen">
<div class="login-content">
<div class="logo text-center">
<img src="{{asset('admin/img/MO-TIV-LOGO.png')}}">
</div>
   <div class="login-box">
   <h2 class="login-head">Forgot Password </h2>
   @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

   <form  method="POST" action="{{ route('password.email') }}">
   <div class="form-group">
      <input id="email" type="email" class="form-control border-input" name="email" value="{{ old('email') }}" required>
	@if ($errors->has('email'))
		<span class="help-block">
			<strong>{{ $errors->first('email') }}</strong>
		</span>
	@endif
	</div>
	{{ csrf_field() }}
   <div class="form-group submit text-center">
   <button type="submit" class="btn btn-info btn-fill btn-wd btn-clr">Submit</button>
   </div>
   </form>
   </div>
</div>


</body>
</div>
    <!--   Core JS Files   -->
    <script src="{{asset('admin/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
	<script src="{{asset('admin/js/bootstrap.min.js')}}" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{{asset('admin/js/bootstrap-checkbox-radio.js')}}"></script>

	<!--  Charts Plugin -->
	<script src="{{asset('admin/js/chartist.min.js')}}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{asset('admin/js/bootstrap-notify.js')}}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="{{asset('admin/js/paper-dashboard.js')}}"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="{{asset('admin/js/demo.js')}}"></script>

	

</html>
