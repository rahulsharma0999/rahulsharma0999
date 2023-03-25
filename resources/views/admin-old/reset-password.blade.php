<html>
<head>
  <link rel="icon" type="image/png" sizes="96x96" href="{{url('admin/assets/img/favicon.png') }}">
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
<div style="margin-bottom: 20px;text-align: center; boder">

  <body class="login">
    <div>
      <div class="login_wrapper">
        <!-- Login Form -->
        <div class="animate form login_form">
          <section class="login_content">
      <div class="text-center logo-wrapper">
      <img src="{{ url('admin/assets/img/logo-2.png' ) }}" alt="Water-works" width="190"/>
      </div>
  
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
                  <h1>Reset Password</h1>
              </div>
              
              <div class="col-xs-12"><label>New password</label>
                <input type="password" class="form-control temp123" placeholder="Password"  name="password" value=""  style="width:400px;text-align:center" required/>
              </div>
                  </br></br></br></br></br></br>
              <div class="col-xs-12"><label>Confirm Password</label>
                <input type="password" class="form-control temp123" placeholder="Confirm Password" style="width:400px;text-align:center" name="confirm_password" required/>
              </div><br>

              <div class="col-xs-12">
               <!-- <a class="btn btn-primary" href="">Login</a> -->
             </br></br></br></br>
        <input type="submit" name="submit" value="Update Password" class="btn btn-primary">
              </div>

              <div class="clearfix"></div>
            </form>
          </section>
        </div>
        
       </div>
      </div>
    </div>
  </body>
</html>
