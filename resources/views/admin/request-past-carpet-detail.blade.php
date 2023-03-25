@extends('layouts.admin-app')
@section('title', 'Carpet Request Detail')
@section('content')
<style>
div.dataTables_wrapper div.dataTables_filter {
    float: right;
}
.address_height {
  height: 142px !important;
}
</style>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <nav class="topBreadcrumb">                
                      <a class="breadcrumb-item">Request Management</a><!--  href="{{url('admin/request-listing')}}" -->
                      <a class="breadcrumb-item"  href="{{url('admin/carpet-past-list')}}" >Carpet Service Request</a>
                      <span class="breadcrumb-item active">Carpet Request Detail</span>
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
                                 <span>Carpet</span>
                                    </div>
                               </li>
                                    
                                    <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Carpet Length
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$data->length}}</span>
                                    </div>
                                    </li>

                                    <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Carpet Width
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$data->width}}</span>
                                    </div>
                                    </li>

                                     <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Amount(KSh)
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$data->amount}}</span>
                                    </div>
                                    </li>


                                      <li>
                                         <div class="sign-up-left">
                                            <label>
                                               Service Date
                                           </label>
                                         </div>
                                        <div class="sign-up-right">
                                           <span>{{$data->date}}</span>
                                        </div>
                                      </li>

                                       <li>
                                         <div class="sign-up-left">
                                            <label>
                                               Time
                                           </label>
                                         </div>
                                        <div class="sign-up-right">
                                           <span>{{$data->time}}</span>
                                        </div>
                                      </li>

                                    <?php
                                    $name = $data->address;
                                    $length = strlen($name);
                                    ?>

                                    @if($length < 50)
                                       <li sty>
                                         <div class="sign-up-left  ">
                                            <label>
                                               Address
                                           </label>
                                         </div>
                                        <div class="sign-up-right  ">
                                           <span>{{$data->address}}</span>
                                        </div>
                                      </li>
                                    @else
                                    <li sty>
                                         <div class="sign-up-left address_height ">
                                            <label>
                                               Address
                                           </label>
                                         </div>
                                        <div class="sign-up-right address_height ">
                                           <span>{{$data->address}}</span>
                                        </div>
                                      </li>
                                    @endif

                                  
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
                                 <span>{{$data->full_name}}</span>
                                    </div>
                               </li>
                                <li>
                                   <div class="sign-up-left">
                                        <label>
                                  Phone 
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$data->phone_number}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Email Address 
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$data->email}}</span>
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
                                            else{
                                              echo ("N/A");
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

                                     <textarea placeholder="Review" disabled>@if(!empty($review->review)) {{$review->review}}  @else N/A   @endif</textarea>
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

     $('#dataTableCustom').DataTable();
    </script>
    @endSection
   