<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('admin/img/favicon.png') }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Lense - @yield('title')</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }} " rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{ asset('admin/css/animate.min.css') }}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('admin/css/paper-dashboard.css') }}" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
     <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('admin/css/themify-icons.css') }}" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ url('admin/dashboard') }}" class="simple-text">
                    <img src="{{ asset('admin/img/logo-2.png') }}" alt="">
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="ti-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/user-list') }}">
                        <i class="ti-user"></i>
                        <p>User Management</p>
                    </a>
                   
                </li>
                <li>
                    <a href="{{ url('admin/photographer-list') }}">
                        <i class="ti-camera"></i>
                        <p>Photographer management</p>
                    </a>
                </li>

                <li>
                    <div class="btn-group">
                      <a href="javascript:void()" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-file"></i> Review Management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/review-user-list') }}">User Reviews</a>
                        <a class="dropdown-item" href="{{ url('admin/review-photographer-list') }}">Photographer Reviews</a>
                      </div>
                    </div>
                </li>
              
                <li>
                    <a href="{{ url('admin/booking-list') }}">
                        <i class="ti-direction"></i>
                        <p>Booking Management</p>
                    </a>
                </li>


                <li>
                    <div class="btn-group">
                      <a href="javascript:void()" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-credit-card"></i> Payment management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/payment-receive-list') }}">Payment recieved</a>
                        <a class="dropdown-item" href="{{ url('admin/payment-request-list') }}">Payment request</a>
                        <a class="dropdown-item" href="{{ url('admin/payment-accept-list') }}">Accept Request</a>
                      </div>
                    </div>
                </li>
                 <li>
                    <div class="btn-group">
                      <a href="javascript:void()" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-gift"></i> Package management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/package-list') }}">Package List</a>
                        <a class="dropdown-item" href="{{ url('admin/add-package-detail') }}">Add package</a>
                       
                      </div>
                    </div>
                </li>
                
               
                <li>
                    <a href="{{ url('admin/change-password') }}">
                        <i class="ti-lock"></i>
                        <p>Change Password</p>
                    </a>
                </li>   
                <li>
                    <a href="{{ url('admin/logout') }}">
                        <i class="ti-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>   
            </ul>
        </div>
    </div>

     <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <!-- <a class="navbar-brand" href="#">Dashboard</a> -->
                </div>
                <div class="collapse navbar-collapse">

                </div>
            </div>
        </nav>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                           <a class="breadcrumb-item" href="{{ url('admin/dashboard') }}">Home</a>
                            @yield('heading')
                        </nav>
                    </div>
                </div>
            </div>
        </section>

    @yield('content')
</div>

</body>

    <!--   Core JS Files   -->
    <script src="{{ asset('admin/js/jquery-1.10.2.js') }}" type="text/javascript"></script>
	<script src="{{ asset('admin/js/bootstrap.min.js') }}" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{{ asset('admin/js/bootstrap-checkbox-radio.js') }}"></script>

	<!--  Charts Plugin -->
	<script src="{{ asset('admin/js/chartist.min.js') }}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ asset('admin/js/bootstrap-notify.js') }}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="{{ asset('admin/js/paper-dashboard.js') }}"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="{{ asset('admin/js/demo.js') }}"></script>

    @yield('js_content')
</html>
