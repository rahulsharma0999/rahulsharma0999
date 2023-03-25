@extends('layouts.admin-app')
@section('title', 'Upholstery Payment Detail')
@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" >Payment Management</a>
                          <a class="breadcrumb-item" href="{{url('admin/upholstery-payment-listing')}}">Upholstery Payment</a>
                          <span class="breadcrumb-item active">Upholstery Payment Details</span>
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
                                     <span>Upholstery service</span>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       No. of Couches
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$request->no_of_couches ?? "N/A"}}</span>
                                        </div>
                                        </li>

                                        <li>
                                           <div class="sign-up-left">
                                                <label>
                                           No. of Dinning Chairs
                                       </label>
                                           </div>
                                            <div class="sign-up-right">
                                         <span>{{$request->no_of_dinning_chair ?? "N/A"}}</span>
                                            </div>
                                        </li>

                                         <li>
                                           <div class="sign-up-left">
                                                <label>
                                           No. of Side Chairs
                                       </label>
                                           </div>
                                            <div class="sign-up-right">
                                         <span>{{$request->no_of_side_chair ?? "N/A"}}</span>
                                            </div>
                                        </li>

                                          <li>
                                           <div class="sign-up-left">
                                                <label>
                                           Others
                                       </label>
                                           </div>
                                            <div class="sign-up-right">
                                         <span>{{$request->others ?? "N/A"}}</span>
                                            </div>
                                        </li>

                                          <li>
                                           <div class="sign-up-left">
                                                <label>
                                           Date
                                       </label>
                                           </div>
                                            <div class="sign-up-right">
                                         <span>{{$request->date}}</span>
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
                                     <span>{{$request->amount ?? "N/A"}}</span>
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
                           <h1 class="main-heading">Payment Details</h1>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Total Amount(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                    <ul class="rating">

                                         {{$payment->amount ?? "N/A"}}
                                            
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





