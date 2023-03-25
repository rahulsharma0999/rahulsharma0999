@extends('layouts.admin-app')
@section('title', 'Review Detail')
@section('heading')
  <a class="breadcrumb-item" href="review-management.html">Review Management</a>
  <span class="breadcrumb-item active">User Management Detail</span>
@endsection

@section('content')
	 <div class="content">
            <div class="container-fluid">
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
                                       </ul>
                                    </div>
                                </div>
                            </div> 


                             <div class="row">
                                <div class="col-sm-4 col-lg-3">
                                    <label>Discription</label>
                                </div>
                                <div class="col-sm-8 col-lg-9">
                                    <div class="infoContent">
                                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
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
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                                    </div>
                                </div>
                            </div> 


                             
                        </div>

                            
                      
                </div>
                        <a href="review-management.html" class="btn btn-success">Back</a>
            </div>
        </div>


@endSection

@section('js_content')

   	<script>
   		
   	</script>
@endSection