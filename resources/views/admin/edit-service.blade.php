@extends('layouts.admin-app')
@section('title', 'Edit service')

@section('content')
<style type="text/css">
.clockpicker {
    position: relative;
} 
.clockpicker span.input-group-addon {
       position: absolute;
    top: 1px;
    bottom: 0;
    margin: auto;
    right: 15px;
    border: 0;
    background: transparent;
    line-height: 24px;

}

.clockpicker  input.form-control {
    cursor: pointer;
}
</style>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" >Service Management</a><!-- href="{{url('admin/service-listing')}}" -->
                          <a class="breadcrumb-item" href="{{url('admin/service-listing')}}">Service Listing</a>
                          <span class="breadcrumb-item active">Edit Service</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                            <div class="signup-wrap login-wrap change-password user-detail-ww">
                            <div class="create-service-ww">
                              <h1 class="main-heading">Edit Service</h1>
                            </div>
                             @if(Session::has('message'))
                             <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <form action="{{url('admin/edit-service/'.$service->id)}}" method="post">
                            {{csrf_field()}}
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="service_name" value="{{$service->service_name}}">
                                     <span class="text-danger">{{$errors->first('service_name')}}</span>   
                                      
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Price(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="service_price" value="{{$service->service_price}}" placeholder="$100">
                                     <span class="text-danger">{{$errors->first('service_price')}}</span>   
                                      
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Duration
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                         <div class="time">
                                        <div class="clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                               <input type="text" name= "service_duration" class="" value="{{$service->service_duration}}">
                                          <span class="input-group-addon">
                                                   <span class="glyphicon glyphicon-time"></span>
                                                   </span>
                                                      </div> 
                                        </div>
        
                                     <span class="text-danger">{{$errors->first('service_duration')}}</span>   
                                        </div>
                                        </li>
                                           <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Description
                                   </label>
                                       </div>
                                        <div class="sign-up-right text_new">
                                          <textarea placeholder="Enter Service Description" name = "service_description" required> {{$service->service_description}}</textarea>
                                      <span class="text-danger">{{$errors->first('service_description')}}</span>   
                                        </div>
                                        </li>
                                        <li class="color-picker">
                                           <div class="sign-up-left">
                                                <label>Select color</label>
                                            </div>
                                            <div class="sign-up-right text_new">
                                              <input type="text" name="color" id="picker" value="{{$service->color}}" />
                                            </div>
                                        </li>
                               </ul>
                               <div class="form-group text-center signup-btn">
                                  
                                   <input type="submit" class="filled-btn" value="Update">
                               </div>
                           </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
  @endSection

   @section('js_content')
 <script type="text/javascript" src="{{url('admin/assets/js/bootstrap-clockpicker.min.js')}}"></script>
        <script type="text/javascript">
             $( function() {
    $( ".datepicker" ).datepicker();
  } );

$('.clockpicker').clockpicker();
$("#picker").drawrpalette();
$(".color-picker button").attr("type","button")
$(".ok,.cancel").css({"background-color":"#9c27b0","border-radius":"5px","padding":"5px","width":"100px","text-transform":"capitalize"})
</script>
    <script>
        
    </script>
    @endSection

   