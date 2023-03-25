@extends('layouts.admin-app')
@section('title', 'Dashboard')

@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="index.html">Dashboard</a>
                          <span class="breadcrumb-item active">User Management</span>
                        </nav>
                    </div>
                </div>
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
                                <th>Sr No.</th>
                                <th class="action">Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr>
                                <td>1</td>
                                <td><span class="ti-image"></span></td>
                                <td>John Doe</td>
                                <td>abc@gmail.com</td>
                             
                                <td><a href="user-detail.html" class="btn btn-danger">view</a> <a href="edit-user-detail.html" class="btn btn-danger">edit</a> <a href="javascript:;" class="btn btn-danger">delete</a> <a href="javascript:;" class="btn btn-danger">Block</a>  </td>
                            </tr>
                              <tr>
                                <td>2</td>
                                <td><span class="ti-image"></span></td>
                                <td>John Doe</td>
                                <td>abc@gmail.com</td>
                              
                                <td><a href="user-detail.html" class="btn btn-danger">view</a> <a href="edit-user-detail.html" class="btn btn-danger">edit</a> <a href="javascript:;" class="btn btn-danger">delete</a> <a href="javascript:;" class="btn btn-danger">Block</a>  </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span class="ti-image"></span></td>
                                <td>John Doe</td>
                                <td>abc@gmail.com</td>
                               
                                <td><a href="user-detail.html" class="btn btn-danger">view</a> <a href="edit-user-detail.html" class="btn btn-danger">edit</a> <a href="javascript:;" class="btn btn-danger">delete</a> <a href="javascript:;" class="btn btn-danger">Block</a>  </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><span class="ti-image"></span></td>
                                <td>John Doe</td>
                                <td>abc@gmail.com</td>
                                <td><a href="user-detail.html" class="btn btn-danger">view</a> <a href="edit-user-detail.html" class="btn btn-danger">edit</a> <a href="javascript:;" class="btn btn-danger">delete</a> <a href="javascript:;" class="btn btn-danger">Block</a>  </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><span class="ti-image"></span></td>
                                <td>John 	Doe</td>
                                <td>abc@gmail.com</td>
                                
                                <td><a href="user-detail.html" class="btn btn-danger">view</a> <a href="edit-user-detail.html" class="btn btn-danger">edit</a> <a href="javascript:;" class="btn btn-danger">delete</a> <a href="javascript:;" class="btn btn-danger">Block</a>  </td>
                            </tr>
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

    <script>
        
    </script>
    @endSection