
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>PreshaWash</title>
    <!-- Bootstrap -->
    <link rel="icon" href="{{url('public/admin/assets/img/favicon1.png')}}" type="image/x-icon">
    <link href="{{url('public/homeAssets')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/style.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/responsive.css" rel="stylesheet">
    <link href="{{url('public/homeAssets')}}/css/font-awesome.min.css" rel="stylesheet">
</head>

<style type="text/css">
    .work_sec figcaption h3 {
    font-weight: 600;
}
</style>

<body>
    <!-- header section -->
    
   <header class="animate">
        <nav class="navbar">
            <div class="container">
            <div class="navbar-header">
              
              <a class="navbar-brand" href="javascript:void(0);"><img src="{{ url('public/admin/assets/img/logo-2.png') }}" alt="logo"></a> 
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
            </div>    
            <div class="menu_bar">
                  <div class="collapse navbar-collapse" id="myNavbar"> 
                     
                      <ul class="nav navbar-nav menu">
                        <li class="active"><a data-scroll  href="#index">Home</a></li>
						<li><a data-scroll  href="#about-us" >About Us</a></li>
                        <li><a data-scroll  href="#how-it-works" > How It Works</a></li>
                        <li><a data-scroll  href="#contact-us">Contact Us</a></li>
                      </ul>
                     
                  </div>
            </div>
          </div>
        </nav>
    </header>
    <!-- header end -->
    <!-- banner section -->
    <section id="index" class="banner_sec">        
       <div id="myCarousel1" class="carousel slide1" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active" style="background:url({{url('public/homeAssets')}}/images/banner_img.png) no-repeat;">
                <div class="container">
                    <div class="banner_caption">
                        <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="banner_contnt">
                               <h3>AN ON-DEMAND CAR CLEANING SERVICE</h3>
                                <p>We bring the car wash to you, wherever you are. </p>
                                <a href="javascript:void(0);" class="app-btn apple-btn"><img src="{{url('public/homeAssets')}}/images/apple-logo.png"> </a> 
                                <a href="javascript:void(0);" class="app-btn"><img src="{{url('public/homeAssets')}}/images/play-store-logo.png"> </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7 ">
                            <div class="img">
                                <figure>
                                    <img src="{{url('public/homeAssets')}}/images/bg-one.png" alt="phone_pic">
                                </figure>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
              <!--<div class="item" style="background:url(https://pocketdeals.ie/web_css/images/banner_img.jpg) no-repeat;">
                <div class="container">
                    <div class="banner_caption">
                        <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="banner_contnt">
                               <h3>DEALS IN YOUR POCKET</h3>
                                <p>Discover the best deals on the things you like wherever you are</p>
                                 <a href="javascript:void(0);" class="app-btn apple-btn"><img src="https://pocketdeals.ie/web_css/images/apple-logo.png"> </a> 
                                <a href="javascript:void(0);" class="app-btn"><img src="https://pocketdeals.ie/web_css/images/play-store-logo.png"> </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7">
                            <div class="img">
                                <figure>
                                    <img src="https://pocketdeals.ie/web_css/images/phone_pic.png" alt="video_img">
                                </figure>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>-->
          </div>
              <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span><img src="https://pocketdeals.ie/web_css/images/left_arrow.png"></span>
              </a>
             <!-- <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span ><img src="https://pocketdeals.ie/web_css/images/right_arrow.png"></span>
              </a>-->
        </div>
    </section>
    <!-- banner section end -->
   
    <!-- featured_sec  -->
    <!--<section class="featured_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <h5><img src="https://pocketdeals.ie/web_css/images/computer.png">Modern</h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
                <div class="col-md-4 col-sm-4">
                    <h5><img src="https://pocketdeals.ie/web_css/images/faster.png">Faster</h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
                <div class="col-md-4 col-sm-4">
                    <h5><img src="https://pocketdeals.ie/web_css/images/reliable.png">Reliable</h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
    </section>-->
    <!-- featured_sec  end -->
     <!-- about section -->
    <section id="about-us" class="about_sec">
        <div class="container">
            <div class="heading">
                <h4>About <span>PreshaWash</span></h4>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="about_contnt">                 
                        <p>PreshaWash is an on-demand car was cleaning service that brings the car wash to you, wherever you are. Home, office or anywhere else. </p> 
						<p>We bring technology to your fingertips with the fastest way to schedule a car wash (date and time) pick a suitable package(s), follow up on the progress of your car wash on the app, pay for your service in app and rate our technicians. </p> 
						<p>We are eco-friendly through the use of reclaim mats to ensure ZERO traces of water, soap and oil residue. We use the reclaimed, re-filtered water to power wash parking lots.  </p>
                        <p> We are pros and strive to always enrich our customers experience. </p>
                      
                    </div>
                </div>
                <div class="col-md-5">
                    <figure class="about-img">
                        <img src="{{url('public/homeAssets')}}/images/bg-two.png">
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <!-- about section end -->
	 <!-- work section -->
    <section id="how-it-works" class="work_sec">
        <div class="container">
            <div class="heading">
                <h4>How It <span>Works</span></h4>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <figure>
                        <img src="{{url('public/homeAssets')}}/images/bg-four.png">
                    </figure>
                    <figcaption><h3>SIGN UP </h3>
                    	
                    </figcaption>
                </div>
                <div class="col-sm-4">
                    <figure>
                        <img src="{{url('public/homeAssets')}}/images/bg-three.png">
                    </figure>
                    <figcaption><h3>REQUEST SERVICE</h3>
                    </figcaption>
                </div>
                  <div class="col-sm-4">
                    <figure>
                        <img src="{{url('public/homeAssets')}}/images/bg-five.png">
                    </figure>
                    <figcaption><h3>SELECT SERVICE</h3>
                    	
                    </figcaption>
                </div>

            </div>
                 
        </div>
    </section>
     <div class="download-apps">
                	<h2><span>Download The App</span></h2>
                	<div class="btn-group">
                		<a href="javascript:void(0);" class="app-btn apple-btn"><img src="{{url('public/homeAssets')}}/images/apple-logo.png"> </a> 
                		<a href="javascript:void(0);" class="app-btn"><img src="{{url('public/homeAssets')}}/images/play-store-logo.png"> </a>
                	</div>
                </div>
    <!-- work section end -->
    <!-- contact_sec -->
    <section id="contact-us" class="contact_sec" style="background:url({{url('public/homeAssets')}}/images/contact_bg.jpg) no-repeat;">
        <div class="container">
		
            <div class="clearfix"></div>
			             <div class="heading">
                <h4>Contact <span>Us</span></h4>
            </div>
         
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}

                    </div>
                    @endif
                       @if(session()->has('error'))
                    <div class="alert alert-danger">
                      {{session()->get('error')}}
                    </div>
                    @endif
                   <form method="post" enctype="multipart/form-data" action="{{url('send-contact-us')}}">
                        {{csrf_field()}}
                        <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                 	<label>Name</label>
                                     <input type="text"  name = "name" value = "" class="form-control" required="">
									  <span class="error-msg"></span>
                                 </div>
                            </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                 	<label>Email Address</label>
                                     <input type="email"  name = "email" value="" class="form-control" required="">
									  <span class="error-msg"></span>
                                 </div>
                            </div>
                             <div class="col-sm-12">
                                 <div class="form-group">
                                 	<label>Message</label>
                                     <textarea maxlength="500" class="form-control" name = "message" required></textarea  />
									  <span class="error-msg"></span>
                                 </div>
                            </div>
                        </div>
                        <div class="form-group button">
                            <input type="submit" name = "submit" value="Submit" class="btn_sub">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- contact_sec  end -->
    <!-- footer section -->
    <footer>
        <div class="container">
            
            <div class="footer-logo">
            	<a href="javascript:void(0);" class="ftr_log"><img src="{{ url('public/admin/assets/img/logo-2.png') }}"></a>
            	            <ul class="social_link">
                <li><a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <!--<li><a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
                <li><a href="javascript:void(0);" class="new"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
            </div>
            <ul class="footer_nav">
                <li><a data-scroll  href="#index">Home</a></li>
                <li><a data-scroll  href="#how-it-works"> How It Works</a></li>
                <li><a data-scroll href="#about-us">About Us</a></li>
                <li><a data-scroll href="#contact-us">Contact Us</a></li>
                <li><a href="{{url('privacy-policy')}}"> Privacy Policy</a></li>
                <li><a data-scroll href="javascript:void(0);">Terms of Use</a></li>
            </ul>
            <span>&copy; 2019 PreshaWash. All Rights Reserved.</span>

        </div>
    </footer>
    <!-- footer  end -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{url('public/homeAssets')}}/js/bootstrap.min.js"></script> 
    @if(session()->has('success') || session()->has('error'))
    <script>
        /*** sticky header ***/
        jQuery(document).ready(function () {
    jQuery('p.comment-form-comment label').html('Comment <span class="required">*</span>');
    //jQuery('p.comment-form-comment label').text('Comment <span class="required">*</span>');
});
jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 1) {
        jQuery('header').addClass("sticky");
    } else {
        jQuery('header').removeClass("sticky");
    }
});
        //////////
        
        $(document).ready(function(){
	$(".navbar-nav>li").click(function(){
		$(".navbar-nav>li").removeClass("active");
		$(this).addClass("active");
	})
})
		jQuery(document).ready(function($) {
  
  function scrollToSection(event) {
    event.preventDefault();
    var $section = $($(this).attr('href')); 
    $('html, body').animate({
      scrollTop: $section.offset().top - 100
    }, 500);
  }
  $('[data-scroll]').on('click', scrollToSection);
}(jQuery));

    $(document).ready(function(){
        if($(".alert")){
             $('html, body').animate({
                    scrollTop: $('#contact-us').offset().top
                }, 1000);
        }
    })

    </script>
    @endif()
	<script>
        setTimeout(function(){
            if($(".alert")){
                $(".alert").remove();
            }
        },5000);

		 /*$(".alert-success").fadeTo(2000, 5000).slideUp(500, function(){
			$(".alert-success").slideUp(500);
		});*/
         
	 </script>
     
</body>

</html>