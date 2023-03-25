@extends('layouts.admin-app')
@section('title', 'Car Payment Detail')
@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item">Payment Management</a>
                          <a class="breadcrumb-item" href="{{url('admin/payment-listing')}}">Car Payment</a>

                          <span class="breadcrumb-item active">Car Payment Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management clearfix">
                            <div class="signup-wrap login-wrap change-password user-detail-ww request-detail-ww clearfix">
                            <div class="col-sm-6">
                            <div class="service-detail">
                            <h1 class="main-heading">Service Details</h1>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->service_name}}</span>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Duration
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->service_duration}}</span>
                                        </div>
                                        </li>
                                      <!--   <li>
                                                                             <div class="sign-up-left">
                                          <label>
                                                                             Service end time
                                                                         </label>
                                                                             </div>
                                      <div class="sign-up-right">
                                                                           <span>4:00 PM</span>
                                      </div>
                                      </li> -->
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Price(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->service_price}}</span>
                                        </div>
                                        </li>
                               </ul>
                           </form>
                           </div>
                           </div>
                           <div class="col-sm-6">
                           <h1 class="main-heading">User Details</h1>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Full Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->full_name}}</span>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                      Phone 
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->phone_number}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Email
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->email}}</span>
                                        </div>
                                        </li>
                                       <!--  <li>
                                                                              <div class="sign-up-left">
                                           <label>
                                                                              Address
                                                                          </label>
                                                                              </div>
                                       <div class="sign-up-right">
                                                                           // <span>mohali</span>
                                       </div>
                                       </li> -->
                               </ul>
                           </form>
                           </div>
                           <div class="col-sm-6">
                           <h1 class="main-heading">Vehicle Details</h1>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Vehicle name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->vehicle_name}}</span>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Brand
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->brand}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Type
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->type}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Colour
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->colour}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       License plate number
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->license_plate_no}}</span>
                                        </div>
                                        </li>
                               </ul>
                           </form>
                           </div>
                       <!--     <div class="col-sm-6">
                       <h1 class="main-heading">Review</h1>
                       <form action="">
                           <ul>
                                  <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Rating
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                <ul class="rating">
                       
                                      <?php
                                        $rating //= $request->rating;
                                       // for($i=0; $i<$rating; $i++) {
                                           //echo '<li><i class="fa fa-star"></i></li>';
                                       // }
                                      ?>
                                        
                                        <li><i class="fa fa-star-half-o"></i></li>
                                   </ul>
                                    </div>
                               </li>
                                <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Review
                               </label>
                                   </div>
                                    <div class="sign-up-right textarea">
                                 <textarea placeholder="Review" disabled>{{$request->review}}</textarea>
                                    </div>
                                    </li>
                           </ul>
                       </form>
                       </div> -->
                            <div class="col-sm-6">
                           <h1 class="main-heading">Payment Details</h1>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Amount(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                    <ul class="rating">

                                         {{$payment->amount}}
                                            
                                            <!--<li><i class="fa fa-star-half-o"></i></li>-->
                                       </ul>
                                        </div>
                                   </li>
                             
                               </ul>
                           </form>
                           </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js_content')
    
    <script>
        $('.del').bind('click', function(){
            var i = $(this).attr('ui');
          
            $('#van_id').val(i);
        });
     
    $('#form1').submit(function() {
      if($('#van_id').val()==0){
        alert('Please select Van');
        return false;
      }
    });
    </script>
    @endSection





