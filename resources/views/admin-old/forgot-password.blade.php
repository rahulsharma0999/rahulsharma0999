<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="icon" type="image/png" sizes="96x96" href="{{url('admin/assets/img/favicon.png')}}">
    <title>Water works - Admin Login</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{url('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{url('admin/assets/css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{url('admin/css/paper-dashboard.css')}}" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
     <link rel="stylesheet" href="{{url('admin/assets/css/style.css')}}">


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{url('admin/assets/css/themify-icons.css')}}" rel="stylesheet">
     
    

</head>
<body>

<section>
            <div class="container">
                <div class="row">
                    <div class="login-section forgot">
                        <div class="login-wrap">
                        <h1 class="main-heading">Forgot Password</h1>
                         @if ($errors->any())
                            <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </div>
                        @endif
                        @if(Session::has('message'))
                        <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                            <div class="login-img">
                            <a href="{{url('admin/login')}}">
                            <img src="assets/img/logo-2.png">
                            </div></a>
                            <form action="{{url('admin/forgot-password')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                <label>Email Address </label>
                                <input type="text" name="email" value="" placeholder="Enter Email Address" required>
                                </div>
                            <div class="form-group login-btn">
                               
                                <input type="Submit" value="Submit" class="filled-btn">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


</body>

   <!--   Core JS Files   -->
    <script src="{{url('admin/assets/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
    <script src="{{url('admin/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="{{url('admin/assets/js/bootstrap-checkbox-radio.js')}}"></script>

    <!--  Charts Plugin -->
    <script src="{{url('admin/assets/js/chartist.min.js')}}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{url('admin/assets/js/bootstrap-notify.js')}}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="{{url('admin/assets/js/paper-dashboard.js')}}"></script>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{url('admin/assets/js/demo.js')}}"></script>

   <script type="text/javascript">
    $('.alert-success').delay(5000).fadeOut('slow');
  </script>
</html>
