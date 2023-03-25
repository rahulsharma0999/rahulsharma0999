<html>
<head>
  <link rel="icon" type="image/png" sizes="96x96" href="{{url('admin/assets/img/favicon.png') }}">
  <title>PreshaWash - Reset password</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
<style>
/*.temp123
{
margin: 0 auto;
margin-left: auto;
margin-right: auto;
text-align:center;
}*/
p.alert.alert-success {
    max-width: 341px!important;
    margin: 0 auto;
}
.login-wrap label{
  text-align: left;
}
.login-wrap {
    padding: 0px 35px 40px 35px;
}
h1.main-heading {
    margin-top: -27px;
    margin-bottom: 27px;
}
.login-img {
    margin-top: 0;
}
</style>
</head>
<div style="margin-bottom: 20px;text-align: center; boder">
   <div class="container">
                <div class="row">
                    <div class="login-section forgot">
                        <div class="login-wrap">
 <div class="login-img">
                            <a href="{{url('admin/login')}}">
                            <img src="{{url('admin/assets/img/logo-2.png')}}">
                            </a></div>     
     <div class="form">
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
  
            <form method="post">
            {{ csrf_field() }}
              <div class="col-xs-12">
<h1 class="main-heading">Reset Password</h1>
              </div>
              
              <div class="col-xs-12"><label>New password</label>
                <input type="password" class="form-control temp123" placeholder="Password"  name="password" value=""   required/>
                 <!-- <input type="password" class="form-control temp123" placeholder="Password"  name="password" value=""  style="width:400px;text-align:center" required/> -->
              </div>
                  </br></br></br></br></br></br>
              <div class="col-xs-12"><label>Confirm Password</label>
                <input type="password" class="form-control temp123" placeholder="Confirm Password"  name="confirm_password" required/>
              </div>
                <!-- <input type="password" class="form-control temp123" placeholder="Confirm Password" style="width:400px;text-align:center" name="confirm_password" required/>
                              </div> -->
              <br>

              <div class="col-xs-12">
               <!-- <a class="btn btn-primary" href="">Login</a> -->
             </br>
        <input type="submit" name="submit" value="Update Password" class="filled-btn">
              </div>

              <div class="clearfix"></div>
            </form>
          </section>
        </div>
        
       </div>
      </div>
    </div>
  </div>
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
     <script>
     $(".alert-danger").fadeTo(2000, 5000).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
    });
   </script>
     <script>
     $(".alert-success").fadeTo(2000, 5000).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });
   </script>
  </body>
</html>
