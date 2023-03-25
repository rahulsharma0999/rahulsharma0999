@extends('layouts.admin-app')
@section('title', 'Review List')

@section('heading')
  <a href="review-management.html" class="breadcrumb-item">Review Management</a>
  <span class="breadcrumb-item active">User Reviews</span>
@endsection

@section('content')
	 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content table-responsive table-full-width">
                            <table id="dataTableCustom" class="table table-striped custmo_data-tbl review-management table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>User Name</th>
                                <th>Photographer Name</th>
                                <th>Rating</th>
                                <th class="maxWidthReview">Review</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                              <tr>
                                <td>1</td>
                                <td>John Deo</td>
                                <td>Harry</td>
                                <td>
                                <ul class="rating">
                                    <li>
                                    <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                    <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                    <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                    <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                    <i class="fa fa-star-half-o"></i>
                                    </li>
                                </ul>
                                </td>
                                <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed </td>
                                <td>
                                <a href="javascript:;" class="btn btn-danger">Delete</a>
                                 <a href="{{ url('admin/view-review-user-detail') }}" class="btn btn-success">View</a>  </td>
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