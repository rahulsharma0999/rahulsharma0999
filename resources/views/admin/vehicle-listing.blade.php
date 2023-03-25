@extends('layouts.admin-app')
@section('title', 'Vehicle Type Listing')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <nav class="topBreadcrumb">                
                      <a class="breadcrumb-item">Vehicle Type Management</a><!--  href="javascript:void(0);" -->
                      <span class="breadcrumb-item active">Vehicle Type Listing</span>
                    </nav>
                </div>
            </div>
             @if(Session::has('message'))
                            <p class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</p>
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
                            <th class="sorting_asc">Vehicle Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach($vans as $van)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$van->type}}</td>
                           
                         
                            <td><a href="{{url('admin/view-vehicle-detail/'.$van->id)}}" class="btn btn-danger">view</a> <a href="{{url('admin/edit-vehicle-detail/'.$van->id)}}" class="btn btn-danger">edit</a> <!-- <a href="#blockPopup"  ui="{{$van->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a> -->
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