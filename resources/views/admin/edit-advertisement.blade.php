@extends('layouts.admin-app')
@section('title', 'Edit Advertisement')
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
    .add-image,.image-name{
          height: 139px!important;
              padding: 18px 34px;

    }
    .space {
    height: 176px!important;
    }
    /*img#blah {
        height: 100px!important;
        object-fit: contain;
    }*/
    img#blah {
          height: 93px!important;
          object-fit: contain;
          margin-bottom: 4px;
          }
    input[type="text"], input[type="password"] {
        height: 40px!important;
        margin-bottom: 3px!important;
    }
    .error{
              color: #B33C12;
    }
    .space1 {
      height: 150px!important;
    }
</style>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" >Advertisement Management</a>
                          <a class="breadcrumb-item" href="{{url('admin/advertisement-listing')}}">Advertisement List</a>
                          <span class="breadcrumb-item active">Edit Advertisement</span>
                        </nav>
                    </div>
                </div>
            </div>


           <!--  <div class="d-flex">
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
            </div> -->

        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                            <div class="signup-wrap login-wrap change-password user-detail-ww">
                            <div class="create-service-ww">
                              <h1 class="main-heading">Edit Advertisement</h1>
                            </div>
                              @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                               @if(Session::has('error'))
                                <p class="alert alert-danger">{{ Session::get('error') }}</p>
                              @endif
                           <!-- <form action="{{url('admin/add-new-vehicle')}}" method="post"> -->
                            <form method="post" enctype="multipart/form-data">
                              {{csrf_field()}}


                            <ul>   
                                <div class="sign-up-left image-name" style="padding-top: 60px;">
                                  <label>
                                       Advertisement Image
                                  </label>
                                </div>
                                <div class="sign-up-right add-image" id="add-image">
                                  <!-- <img src="{{url('admin/assets/img/add_image.png')}}" width="100" > 
                                  <span class="text-danger">{{$errors->first('couche')}}</span>   -->  

                                                            <?php
                                                                $url = url('storage/advertisement_images/');
                                                                $file_name = $data->image; 
                                                                if($file_name){
                                                                    $result = $url.'/'.$file_name;
                                                                }else{ 
                                                                    $result = url('admin/assets/img/add_image.png ');
                                                                }
                                                            ?>

                                                      <div class="user_img" data-toggle="tooltip" data-placement="top" title="Upload Image">
                                                            <div  class="img-wraps"> 
                                                              <img  title="Click to change image" width="100"  onclick="$('#imgInp').click()" src='{{$result}}' id="blah" style="cursor: pointer" />
                                                              <input style="display:none; " type="file" id="imgInp" name="image" data-role="magic-overlay"
                                                                   data-target="#pictureBtn" value="" class="user_img" >
                                                            </div>
                                                            <span style="display:none; font-weight: 400; color: #f90303!important; margin-top: 8px;" class="text-danger" id="invalid_file">Please select jpg, jpeg or png image format only. </span>
 
                                                            <span class = "error" id="err-image" style="margin-top: 8px;">{{$errors->first('image')}}</span>
                                                          </div>
                                </div> 
                            </ul>


                            <ul>   
                                <div class="sign-up-left ">
<!-- width-space -->                                  <label>
                                       Advertisement Title
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="50" name="title" value="{{$data->title}}"  placeholder="Enter Title " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('title')}}</span>    
                                </div> 
                            </ul>



                            <ul>   
                                <div class="sign-up-left">
                                  <label>
                                       Advertisement Link
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="400" name="link"  value="{{$data->link}}" placeholder="Enter Link " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('link')}}</span>    
                                </div> 
                            </ul>


                           <!--  @if (!empty($data->amount_per_square)) 
                               <div class="form-group text-center signup-btn">
                                   <input type="Submit"  class="filled-btn" value="Update">
                               </div>
                            @else -->
                               <div class="form-group text-center signup-btn">
                                   <input type="Submit"  class="filled-btn" value="Update">
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
 <!-- image -->
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {


              let add_img = "{{url('storage/advertisement_images')}}"+"/"+"{{$data->image}}";

                var type = (input.files[0].type);

                if (type == "image/png" || type == "image/jpeg" || type == "image/gif") {
                    $('#invalid_file').css({'display': 'none'});

                    $("#err-image").hide();

                    // $(".space").removeClass("space");
                    $(".image-name").removeClass( "space" );
                    $(".add-image").removeClass( "space" );

                    $(".image-name").removeClass( "space1" );
                    $(".add-image").removeClass( "space1" );
                } else {
                    $("#blah").attr("src",add_img);
                    $('#invalid_file').css({'display': 'block'});
                    $("#invalid_file").text("Please select jpg, jpeg or png image format only.");
                    $('#imgInp').val('');
                    $("#imgInp").removeAttr("img");
                    $(".closes").hide();

                    $(".image-name").addClass( "space" );
                    $(".add-image").addClass( "space" );


                    return false;
                }
                var reader = new FileReader();

                reader.onload = function (e) {
                     var img = new Image;
                      img.onload = function() {
                        var width = img.width;
                        var height = img.height;
                        console.log(width)
                        console.log(height)
                        if (width === height) {
                             $('#blah').attr('src', e.target.result);

                              $("#imgInp").attr("img","true");
                              $(".closes").show();

                          }else{
                             $('#invalid_file').css({'display': 'block'});
                              $("#invalid_file").text("Only 1:1 ratio images are allowed.");
                              $("#blah").attr("src",add_img);
                              $('#imgInp').val('');
                              $("#imgInp").removeAttr("img");
                              $(".closes").hide();

                              $(".image-name").addClass( "space1" );
                              $(".add-image").addClass( "space1" );

                              $(".error").hide();
                          return false;
                        }
                      }
            
                      img.src = reader.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInp").change(function () {
            readURL(this);
        });

    </script>



      <script type="text/javascript"> 
        $(function(){
        setTimeout(function(){
            $("#error_alert , .alert-danger").hide();
            }, 5000);
          });
    </script>

    <script type="text/javascript"> 
        $(function(){
        setTimeout(function(){
            $("#success_alert").hide();
            }, 5000);
          });

    </script>
@endSection
