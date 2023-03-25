
<html>
<head>
  <link rel="icon" type="image/png" sizes="96x96" href="{{url('admin/assets/img/favicon1.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>:: success:: </title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
.temp123
{
margin: 0 auto;
margin-left: auto;
margin-right: auto;
text-align:center;
}
p.alert.alert-success {
    max-width: 341px!important;
    margin: 0 auto;
}
</style>
</head>
<div style="margin-bottom: 20px;text-align: center;">

   
  </head>
  <body class="login">
    <div>
     
      <div class="login_wrapper">
        <!-- Login Form -->
        <div class="animate form login_form">
          <section class="login_content">
          <div class="text-center logo-wrapper">

           <a href="{{url('admin/login')}}" ><img src="{{ url('admin/assets/img/logo-2.png') }}" alt="Water-works" width="190"/></a>
          </div>
        @if(Session::has('success'))
          <p class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
          </section>
        </div>
        </div>
       
      </div>
    </div>
  </body>
</html>
