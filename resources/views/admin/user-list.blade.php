@extends('layouts.admin-app')
@section('title', 'Users listing')

@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" >User Management</a> <!-- //href="{{url('admin/dashboard')}}"" -->
                          <span class="breadcrumb-item active">User Listing</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>


        <div class="content">
            <div class="container-fluid">
                @if(Session::has('message'))
                             <p class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</p>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="content table-responsive table-full-width">
                            
                            <table id="dataTableCustom" class="table table-striped custmo_data-tbl table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <!--<th class="action">Image</th>-->
                                <th>Name</th>
                                <th>Email</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                           @foreach($users as $user)  
                            <tr>
                                <td>{{$i++}}</td>
                               
                                <!--<td><img src="@if(!empty($user->image)) {{$user->image}} @else {{url('admin/assets/img/user.png')}} @endif"  alt="Doggo" align="middle" class="ti-image" height="50px" width="50px"></td>-->
                                <td>{{$user->full_name}}</td>
                                <td>{{$user->email}}</td>
                             
                                <td><a href="{{url('admin/view-user-detail/'.$user->id)}}" class="btn btn-danger">view</a> <a href="{{url('admin/edit-user-detail/'.$user->id)}}" class="btn btn-danger">edit</a> <!-- <a href="#blockPopup"  ui="{{$user->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a> --> <a href="{{url('admin/block-action-user/'.$user->id)}}" class="btn btn-danger">@if($user->block_status == 1)Block @else Unblock @endif</a></td>
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
    
   @endSection
        


   @section('js_content')
   <div id="blockPopup" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <p>Do  you really want to delete it?</p>
                    <form id="del" action="{{url('admin/delete-user')}}" method="post">
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