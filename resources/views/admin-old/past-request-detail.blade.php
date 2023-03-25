@extends('layouts.admin-app')
@section('title', 'Dashboard')
@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="{{url('admin/past-requests')}}">Request Management</a>
                          <span class="breadcrumb-item active">Past Request Detail</span>
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
                            <h1 class="main-heading">Service Detail</h1>
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
                                   Service Date
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{date('d-m-Y',strtotime($request->service_date))}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service  Time
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{ date('h:i A', strtotime($request->service_time))  }}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Total Time
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->service_duration}} Hours</span>
                                    </div>
                                    </li>
                                     <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Total Amount(KSh)
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->total_price}}</span>
                                    </div>
                                    </li>
                               </ul>
                           </form>
                           </div>
                           </div>
                           <div class="col-sm-6">
                           <h1 class="main-heading">User Detail</h1>
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
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Address
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->service_address}}</span>
                                        </div>
                                        </li>
                               </ul>
                           </form>
                           </div>
                           <div class="col-sm-6">
                           <h1 class="main-heading">Vehicle Detail</h1>
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
                           <div class="col-sm-6">
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
                                            if(!empty($review->rating)){
                                              for($star=1;$star <= $review->rating;$star++){ 
                                                echo '<li><i class="fa fa-star"></i></li>';
                                              } 
                                            }
                                            ?>
                                             <!--<li><i class="fa fa-star-half-o"></i></li>-->
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

                                     <textarea placeholder="Review">@if(!empty($review->review)) {{$review->review}} @endif</textarea>
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





