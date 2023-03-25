@extends('layouts.admin-app')
@section('title', 'Dashboard')

@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a href="{{url('admin/reviews')}}" class="breadcrumb-item">Review Management</a>
                          <span class="breadcrumb-item active">Review Listing</span>
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
                            <table id="dataTableCustom" class="table table-striped custmo_data-tbl review-management table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Booking Id</th>
                                <th>User Name</th>
                                <th>Rating</th>
                                <th class="maxWidthReview">Review</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($reviews as $review)
                              <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $review->request_id}}</td>
                                <td>{{ $review->full_name}}</td>
                                
                                <td>
                                <ul class="rating">
                                    <?php
                                        $rating = $review->rating;
                                    for($i=0; $i<$rating; $i++) {
                                        echo '<li><i class="fa fa-star"></i></li>';
                                    }
                                    ?>
                                </ul>
                                </td>
                                <td><?php  echo $out = strlen($review->review) > 40 ? substr($review->review,0,40)."..." : $review->review;?></td>
                                <td>
                                <a href="{{url('admin/review-detail/'.$review->request_id)}}" class="btn btn-danger">view</a>
                                 
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
 <script>
        
   $('#dataTableCustom').DataTable();
</script>
@endsection