
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>@yield("title")</title>
    <!-- Bootstrap -->
    <link rel="icon" href="{{url('public/homeAssets')}}/images/favicon.png" type="image/x-icon">
    <link href="{{url('public/homeAssets')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/style.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/responsive.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <!-- header section -->
    
   <header class="animate">
        <nav class="navbar">
            <div class="container">
            <div class="navbar-header">
              
              <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('public/homeAssets')}}/images/logo.png" alt="logo"></a> 
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
            </div>    
            <div class="menu_bar">
                  <div class="collapse navbar-collapse" id="myNavbar"> 
                      
                      <ul class="nav navbar-nav menu">
                        <li class="active"><a  href="{{url('/')}}">Home</a></li>
					             	<li><a  href="{{url('/')}}/#about-us" >About Us</a></li>
                        <li><a href="{{url('/')}}/#how-it-works" > How It Works</a></li>
                        <li><a href="{{url('/')}}/#contact-us">Contact Us</a></li>
                      </ul>
                     
                  </div>
            </div>
          </div>
        </nav>
    </header>
    <!-- header end -->