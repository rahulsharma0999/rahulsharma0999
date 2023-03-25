@extends('layouts.admin-app')
@section('title', 'Dashboard')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <nav class="topBreadcrumb">                
                      <a class="breadcrumb-item" href="service-van-management.html">Service Van Management</a>
                      <span class="breadcrumb-item active">Van Listing</span>
                    </nav>
                </div>
            </div>
             @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
        </div>
    </section>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                       
                        <div class="content table-responsive table-full-width">
                        
                        <table id="dataTableCustom" class="table table-striped custmo_data-tbl table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="sorting_asc">Sr No.</th>
                            <th class="sorting_asc">Van Name</th>
                            <th class="sorting_asc">Van Id</th>
                            <th class="sorting_asc">Van Email</th>
                            <th class="sorting_asc">License Plate Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach($vans as $van)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$van->name}}</td>
                            <td>{{$van->number}}</td>
                            <td>{{$van->email}}</td>
                            <td>{{$van->license_plate_no}}</td>
                         
                            <td><a href="{{url('admin/view-van-detail/'.$van->id)}}" class="btn btn-danger">view</a> <a href="{{url('admin/edit-van-detail/'.$van->id)}}" class="btn btn-danger">edit</a> <a href="#blockPopup"  ui="{{$van->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
         
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
                    <form id="del" action="{{url('admin/delete-van')}}" method="post">
                        {{ csrf_field() }}
                        <input id = "row_del" name = "row_del" type="hidden"  >
                    </form>
                    <button type="button" onclick="$('#del').submit()" class="btn-primary" id="modal-btn-si">Yes</button>
                    <button type="button" class="btn-danger" data-dismiss="modal">No</button>
              </div>
            </div>

          </div>
        </div>

   <script type="text/javascript">
       
     $('#dataTableCustom').DataTable();


  
   </script>
 
   <script>
        $('.del').bind('click', function() {
            var i = $(this).attr('ui');
            $('#row_del').val(i);
        });
    </script>
    @endSection