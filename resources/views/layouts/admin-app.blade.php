<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{url('admin/assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{url('admin/assets/img/favicon1.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>PreshaWash - @yield('title')</title>
  <style type="text/css">
    .drawrpallete-wrapper {
      margin-top:9px;
    }
   .drawrpallete-wrapper  button.cancel ,.drawrpallete-wrapper  button.ok {
    color:white  !important;
   }
  
  </style>


  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ url('admin/assets/css/bootstrap.min.css') }} " rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{ url('admin/assets/css/animate.min.css') }}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ url('admin/assets/css/paper-dashboard.css') }}" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
     <link rel="stylesheet" href="{{ url('admin/assets/css/style.css') }}">


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ url('admin/assets/css/themify-icons.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/bootstrap-clockpicker.min.css')}}">

</head>

<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

      <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{url('admin/dashboard')}}" class="simple-text">
                    <img src="{{url('admin/assets/img/logo-2.png')}}" alt="">
                </a>
            </div>

            <ul class="nav">
                <li class="@if(Request::is('admin/dashboard')) active @endif">
                    <a href="{{url('admin/dashboard')}}">
                        <i class="ti-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li  class="@if(Request::is('admin/user-list') || Request::is('admin/view-user-detail/*') || Request::is('admin/edit-user-detail/*'))  active @endif">
                   <div class="btn-group @if(Request::is('admin/user-list') || Request::is('admin/view-user-detail/*') || Request::is('admin/edit-user-detail/*')) open @endif">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i>
                        User Management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/user-list')}}">User Listing</a>
                      </div>
                    </div>
                </li>




                <li  class="@if(Request::is('admin/advertisement-listing') || Request::is('admin/add-advertisement') || Request::is('admin/edit-advertisement/*'))  active @endif">
                   <div class="btn-group @if(Request::is('admin/advertisement-listing') || Request::is('admin/add-advertisement') || Request::is('admin/edit-advertisement/*')) open @endif">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-snowflake-o"></i>
                        Advertisement Management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/advertisement-listing')}}">Advertisement Listing</a>
                      </div>
                    </div>
                </li>






                <li class="@if(Request::is('admin/service-listing') || Request::is('admin/create-service') || Request::is('admin/edit-service/*') || Request::is('admin/carpet-service')  || Request::is('admin/carpet-measurement') || Request::is('admin/carpet-measurement-list')  || Request::is('admin/upholstery-service')  || Request::is('admin/upholstery-couches')  || Request::is('admin/upholstery-dinning-chair')   || Request::is('admin/upholstery-side-chair') || Request::is('admin/edit-carpet-measurement/*')   ) active @endif">
                   <div class="btn-group @if(Request::is('admin/service-listing') || Request::is('admin/create-service') || Request::is('admin/carpet-service')  || Request::is('admin/edit-service/*') || Request::is('admin/carpet-service')  || Request::is('admin/carpet-measurement')  || Request::is('admin/carpet-measurement-list') || Request::is('admin/upholstery-service')  || Request::is('admin/upholstery-couches')  || Request::is('admin/upholstery-dinning-chair')   || Request::is('admin/upholstery-side-chair')  || Request::is('admin/edit-carpet-measurement/*') ) open @endif">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-car"></i>
                        Service Management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/service-listing')}}">Service Listing</a>
                        <a class="dropdown-item" href="{{url('admin/create-service')}}">Car Service</a>
                        <a class="dropdown-item" href="{{url('admin/carpet-measurement-list ')}}">Carpet Service</a>
                        <a class="dropdown-item" href="{{url('admin/upholstery-service')}}">Upholstery Service</a>
                      </div>
                    </div>
                </li>


                <li class="@if(Request::is('admin/request-listing') ||  Request::is('admin/request-detail/*') || Request::is('admin/past-requests') || Request::is('admin/past-request-detail/*')  ||  Request::is('admin/carpet-new-list')  ||  Request::is('admin/carpet-past-list')  ||  Request::is('admin/request-new-carpet-detail/*')  ||  Request::is('admin/request-past-carpet-detail/*') ||  Request::is('admin/upholstery-new-list')  ||  Request::is('admin/upholstery-past-list')  ||  Request::is('admin/request-new-upholstery-detail/*')  ||  Request::is('admin/request-past-upholstery-detail/*')  ) active @endif">
                   <div class="btn-group  @if(Request::is('admin/request-listing') || Request::is('admin/request-detail/*') || Request::is('admin/past-requests') || Request::is('admin/past-request-detail/*')  || Request::is('admin/carpet-new-list') || Request::is('admin/carpet-past-list')  || Request::is('admin/request-new-carpet-detail/*')  ||  Request::is('admin/request-past-carpet-detail/*')  || Request::is('admin/upholstery-new-list') || Request::is('admin/upholstery-past-list')  || Request::is('admin/request-new-upholstery-detail/*')  ||  Request::is('admin/request-past-upholstery-detail/*')  ) open @endif">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope-square"></i>
                        Request Management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/request-listing')}}">Car Service request</a>
                        <a class="dropdown-item" href="{{url('admin/carpet-new-list')}}">Carpet Service Request</a>
                        <a class="dropdown-item" href="{{url('admin/upholstery-new-list')}}">Upholstery Service Request</a>
                      </div>
                    </div>
                <!-- </li>
                <li class="@if(Request::is('admin/reviews') || Request::is('admin/review-detail/*') ) active @endif">
                    <a href="{{url('admin/reviews')}}">
                        <i class="ti-file"></i>
                        <p>Review management</p>
                    </a>
                </li> -->



                <li class="@if(Request::is('admin/reviews') || Request::is('admin/review-detail/*')  || Request::is('admin/carpet-reviews')  || Request::is('admin/carpet-review-detail/*') || Request::is('admin/upholstery-reviews')  || Request::is('admin/upholstery-review-detail/*') ) active @endif">
                    <div class="btn-group @if(Request::is('admin/reviews') || Request::is('admin/review-detail/*')  || Request::is('admin/carpet-reviews')  || Request::is('admin/carpet-review-detail/*')  || Request::is('admin/upholstey-reviews')  || Request::is('admin/upholstey-review-detail/*')  )  open @endif ">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-credit-card"></i> Review management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/reviews')}}">Car Review</a>
                        <a class="dropdown-item" href="{{url('admin/carpet-reviews')}}">Carpet Review</a>
                        <a class="dropdown-item" href="{{url('admin/upholstery-reviews')}}">Upholstery Review</a>
                      </div>
                    </div>
                </li>




                <li class="@if(Request::is('admin/payment-listing') || Request::is('admin/payment-detail/*')  || Request::is('admin/carpet-payment-listing')  || Request::is('admin/carpet-payment-detail/*')   || Request::is('admin/upholstery-payment-listing')  || Request::is('admin/upholstery-payment-detail/*')  ) active @endif">
                    <div class="btn-group @if(Request::is('admin/payment-listing') || Request::is('admin/payment-detail/*')  || Request::is('admin/carpet-payment-listing')  || Request::is('admin/carpet-payment-detail/*')  || Request::is('admin/upholstery-payment-listing')  || Request::is('admin/upholstery-payment-detail/*')   )  open @endif ">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-credit-card"></i> Payment management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/payment-listing')}}">Car Payment</a>
                        <a class="dropdown-item" href="{{url('admin/carpet-payment-listing')}}">Carpet Payment</a>
                        <a class="dropdown-item" href="{{url('admin/upholstery-payment-listing')}}">Upholstery Payment</a>

                      </div>
                    </div>
                </li>


                 <li class="@if(Request::is('admin/service-van-listing') || Request::is('admin/view-van-detail/*') || Request::is('admin/add-new-van') || Request::is('admin/edit-van-detail/*') ) active @endif">
                    <div class="btn-group @if(Request::is('admin/service-van-listing') || Request::is('admin/view-van-detail/*') ||  Request::is('admin/add-new-van') || Request::is('admin/edit-van-detail/*') )  open @endif ">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bus"></i> Service van management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/service-van-listing')}}">Van Listing</a>
                        <a class="dropdown-item" href="{{url('admin/add-new-van')}}">Add new van</a>
                       
                      </div>
                    </div>
                </li>

                  <li class="@if(Request::is('admin/vehicle-listing') || Request::is('admin/view-vehicle-detail/*') || Request::is('admin/add-new-vehicle') || Request::is('admin/edit-vehicle-detail/*') ) active @endif">
                    <div class="btn-group @if(Request::is('admin//vehicle-listing') || Request::is('admin/view-vehicle-detail/*') ||  Request::is('admin/add-new-vehicle') || Request::is('admin/edit-vehicle-detail/*') )  open @endif ">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bus"></i> Vehicle Type management</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/vehicle-listing')}}">Vehicle Listing</a>
                        <a class="dropdown-item" href="{{url('admin/add-new-vehicle')}}">Add new Vehicle</a>
                       
                      </div>
                    </div>
                </li>
                     <li class="@if(Request::is('admin/location-tracking')) active @endif">
                        <div class="btn-group  @if(Request::is('admin/location-tracking')) open @endif">
                          <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe"></i> Location tracking</a>
                          <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="ti-angle-right"></span>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{url('admin/location-tracking')}}">Van location</a>
                           
                          </div>
                        </div>
                    </li>
               
                <li class="@if(Request::is('admin/change-password')) active @endif">
                    <div class="btn-group @if(Request::is('admin/change-password')) open @endif">
                      <a href="javascript:void(0);" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> My profile</a>
                      <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ti-angle-right"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('admin/change-password')}}">Change password</a>
                       
                      </div>
                    </div>
                </li>   
                <li>
                    <a href="#logoutPopup" data-toggle="modal" data-target="#logoutPopup">
                        <i class="fa fa-sign-out"></i>
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
        
    @yield('content')
</div>

</body>
   
    <!--   Core JS Files   -->
    <script src="{{ url('admin/assets/js/jquery-1.10.2.js') }}" type="text/javascript"></script>
  <script src="{{ url('admin/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

  <!--Data list-->
    <script src="{{ url('admin/assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('admin/assets/js/jquery.dataTables.min.js') }}"></script>
  <!--  Checkbox, Radio & Switch Plugins -->
  <script src="{{ url('admin/assets/js/bootstrap-checkbox-radio.js') }}"></script>

  <!--  Charts Plugin -->
  <script src="{{ url('admin/assets/js/chartist.min.js') }}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ url('admin/assets/js/bootstrap-notify.js') }}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
  <script src="{{ url('admin/assets/js/paper-dashboard.js') }}"></script>
  <!-- bootstrap-datetimepicker js -->
    <script src="{{ url('admin/assets/js/moment-with-locales.js')}}"></script>
  <script src="{{ url('admin/assets/js/bootstrap-datetimepicker.js')}}"></script>

  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{ url('admin/assets/js/demo.js') }}"></script>   
  <script type="text/javascript" src="{{ url('admin/assets/color-picker/jquery.drawrpalette-min.js') }}"></script>
  <script type="text/javascript">
      $(document).ready(function(){
        $(document).on("load","#picker",function(){
          $(this).attr("dasd","adsadsd")
        })
      })
    </script>
  <script type="text/javascript">
    $('.alert-success').delay(5000).fadeOut('slow');
  </script>

    @yield('js_content')
    <div id="logoutPopup" class="modal fade" role="dialog">
      <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-body">
        <p>Do  you really want to log out?</p>
         <form id="out" action="{{url('admin/log-out')}}" method="post">
            {{ csrf_field() }}
            <input id = "row_del" name = "row_del" type=  "hidden">
            
          </form>
          <button type="button" onclick="$('#out').submit()" class="btn-primary" id="modal-btn-si">Yes</button>
          <button type="button" class="btn-danger" data-dismiss="modal">No</button>
        </div>
      </div>

      </div>
    </div>
    

</html>
