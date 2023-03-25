@extends('layouts.admin-app')
@section('title', 'Payment Accept Detail')
@section('heading', 'Home')
@section('heading')
    <a href="payment-management.html" class="breadcrumb-item">Payment Management</a>
    <span class="breadcrumb-item active">Order Detail</span>
@endsection

@section('content')
      <div class="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                            <div class="col-sm-12 text-center">
                                    <label>User Detail</label>
                            </div>
                          </div>
                    <div class="card">

                        <div class="infomationSection">
                          
                            <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Image</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <span class="ti-image imageICon"></span>
                                    </div>
                                </div>
                            </div>   

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Name</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>John</p>
                                    </div>
                                </div>
                            </div> 

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Email</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>john@gmail.com</p>
                                    </div>
                                </div>
                            </div> 

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Phone Number</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>9876543210</p>
                                    </div>
                                </div>
                            </div> 

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>location</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>Jalandhar</p>
                                    </div>
                                </div>
                            </div> 


                             
                        </div>

                            
                      
                </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                            <div class="col-sm-12 text-center">
                                    <label>Photographer Detail</label>
                            </div>
                          </div>
                    <div class="card">
                        <div class="infomationSection">
                            <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Image</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <span class="ti-image imageICon"></span>
                                    </div>
                                </div>
                            </div>   

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Name</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>John</p>
                                    </div>
                                </div>
                            </div> 

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Email</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>john@gmail.com</p>
                                    </div>
                                </div>
                            </div> 

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Phone Number</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p>9876543210</p>
                                    </div>
                                </div>
                            </div> 

                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Rating</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                       <ul class="rating">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-half-o"></i></li>
                                            <li>4.5</li>

                                       </ul>
                                    </div>
                                </div>
                            </div> 


                            
                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Review</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                            </div> 


                             
                        </div>

                            
                      
                </div>
                  </div>
                </div>
            </div>
        </div>


        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content booking-management">
                        <div class="row">
                          <div class="col-xs-12">
                            <h2 class="sub-heading">Order Details</h2>
                          </div>
                          <div class="col-xs-12">
                          <div class="b-m-order-details">
                            <ul>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Selected packages</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <p>2 photos for $24.00</p>
                                </div>
                              </li>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Order number</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <p>12121</p>
                                </div>
                              </li>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Amount</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <p>$24.00</p>
                                </div>
                              </li>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Booking date</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <p>24-6-2018</p>
                                </div>
                              </li>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Booking time</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <p>Booking time</p>
                                </div>
                              </li>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Rating</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <ul class="rating">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-half-o"></i><span>4.5</span></li>
                                  </ul>
                                </div>
                              </li>
                              <li>
                                <div class="b-m-o-d-left">
                                  <p>Note</p>
                                </div>
                                <div class="b-m-o-d-right">
                                  <form>
                                    <div class="form-group">
                                       <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                  </form>
                                </div>
                              </li>
                            </ul>
                          </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 text-left">
                    <a href="payment-management.html" class="filled-btn">Back</a>
                  </div>
                </div>
            </div>
        </div>


@endSection
@section('js_content')

   	<script>
   		
   	</script>
@endSection