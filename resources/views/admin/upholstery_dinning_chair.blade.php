@extends('layouts.admin-app')
@section('title', 'Upholstery Dinning Chairs')
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
    .card .table tbody td:first-child, .card .table thead th:first-child {
    padding-left: 9px;
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
                          <span class="breadcrumb-item active">Upholstery Dinning Chairs</span>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="d-flex">
                <div class="ser_req_btn past_btn ">
                    <a class="" href="{{url('admin/upholstery-service')}}">
                        <input type="submit" class="filled-btn" value="Upholstery Price">
                    </a>
                </div>
                <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/upholstery-couches')}}">
                        <input type="submit" class="filled-btn" value="Upholstery Couches">
                    </a>
                </div>
              <div class="ser_req_btn ">
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
                              <h1 class="main-heading">Add Upholstery Dinning Chairs</h1>
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
                                       Number of Dinning Chairs
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="5" name="dinning_chair"  placeholder="Please enter dinning chair " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('dinning_chair')}}</span>    
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


                    @if(Session::has('messages'))
                        <p class="alert alert-success">{{ Session::get('messages') }}</p>
                     @endif
                    <!-- Listing -->
                    <div class="content table-responsive table-full-width">
                                  <table id="dataTableCustom" class="table table-striped custmo_data-tbl table-bordered" style="width:100%">
                              <thead>
                                  <tr>
                                      <th>Sr No.</th>
                                      <th>Number of Dinning Chairs</th>
                                      <th class="action">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                              @php($i=1)
                                  @foreach($data as $data) 
                                  <tr>
                                     <th>{{$i++}}</th>
                                      <td>{{$data->no_of_dinning_chairs}}</td>
                                      <td>
                                       <a href="#blockPopup"  ui="{{$data->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a>
                                  </tr>
                                  @endforeach
                              </tbody>
                          </table>
                          </div>


                    </div>
                </div>
            </div>
        </div>


  @endsection
   @section('js_content')
    <div id="blockPopup" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <p>Do  you really want to delete it?</p>
                    <form id="del" action="{{url('admin/delete-dinning-chair/'.'*')}}" method="post">
                        {{ csrf_field() }}
                        <input id = "row_del" name = "id" type="hidden"  >
                    </form>
                    <button type="button" onclick="$('#del').submit()" class="btn-primary" id="modal-btn-si">Yes</button>
                    <button type="button" class="btn-danger" data-dismiss="modal">No</button>
              </div>
            </div>
          </div>
    </div>
    <script>
        $('.del').bind('click', function() {
            var i = $(this).attr('ui');
            $('#row_del').val(i);
        });
           $('#dataTableCustom').DataTable();
    </script>
    @endSection