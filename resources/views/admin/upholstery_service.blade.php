@extends('layouts.admin-app')
@section('title', 'Upholstery Price')
@section('content')
<style type="text/css">
.d-flex {
        display: flex;
        margin-left: 30px;
         margin-top: 15px;
         flex-wrap: wrap;
    }
    .ser_req_btn {
        margin-right: 12px;
        margin-bottom: 14px;
    }
.past_btn .filled-btn {
        background-color: transparent;
        color: #000000;
    }
    .past_btn .filled-btn:hover {
        color: #fff;
    }
    .width-space{
          padding-top: 21px!important;

    }
    .filled-btn{
          padding: 10px 41px;
    }
</style>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item">Service Management</a>
                          <span class="breadcrumb-item active">Upholstery Price</span>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="d-flex">
                <div class="ser_req_btn ">
                    <a class="" href="{{url('admin/upholstery-service')}}">
                        <input type="submit" class="filled-btn" value="Upholstery Price">
                    </a>
                </div>
                <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/upholstery-couches')}}">
                        <input type="submit" class="filled-btn" value="Upholstery Couches">
                    </a>
                </div>
                <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/upholstery-dinning-chair')}}">
                        <input type="submit" class="filled-btn" value="Upholstery Dinning Chairs">
                    </a>
                </div>
                <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/upholstery-side-chair')}}">
                        <input type="submit" class="filled-btn" value="Upholstery Side Chairs">
                    </a>
                </div>
            </div>

        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                            <div class="signup-wrap login-wrap change-password user-detail-ww">
                            <div class="create-service-ww">
                              <h1 class="main-heading">Add Upholstery Price</h1>
                            </div>
                              @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <!-- <form action="{{url('admin/add-new-vehicle')}}" method="post"> -->
                            <form method="post">
                              {{csrf_field()}}


                            <ul>   
                                <div class="sign-up-left">
                                  <label>
                                       Price Per Couches(KSh)
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="10" name="couche" value="{{$data->couche_price ?? ""}}" placeholder="Price " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('couche')}}</span>    
                                </div> 
                            </ul>


                            <ul>   
                                <div class="sign-up-left ">
<!-- width-space -->                                  <label>
                                       Price Per Dinning Chair(KSh)
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="10" name="dinning_chair" value="{{$data->dinning_chair_price ?? ""}}" placeholder="Price " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('dinning_chair')}}</span>    
                                </div> 
                            </ul>



                            <ul>   
                                <div class="sign-up-left">
                                  <label>
                                       Price Per Side Chair(KSh)
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="10" name="side_chair" value="{{$data->side_chair_price ?? ""}}" placeholder="Price " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('side_chair')}}</span>    
                                </div> 
                            </ul>


                           <!--  @if (!empty($data->amount_per_square)) 
                               <div class="form-group text-center signup-btn">
                                   <input type="Submit"  class="filled-btn" value="Update">
                               </div>
                            @else -->
                               <div class="form-group text-center signup-btn">
                                   <input type="Submit"  class="filled-btn" value="Submit">
                               </div>
                            <!-- @endif -->
                           </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>


  @endsection
   @section('js_content')


    @endSection
