@extends('layouts.admin-app')
@section('title', 'Carpet Review')

@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a  class="breadcrumb-item">Review Management</a><!-- href="{{url('admin/reviews')}}" -->
                          <span class="breadcrumb-item active">Carpet Review</span>
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
                                <th>Booking ID</th>
                                <th>User Name</th>
                                <th>Rating</th>
                                <th class="maxWidthReview">Review</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             
                            @foreach($reviews as $review)
                               @php 
                           $formId = "form".$loop->iteration;
                           @endphp

                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $review->carpet_request_id}}</td>
                                <td>{{ $review->full_name}}</td>
                                
                                <td>
                                <ul class="rating">
                                    <?php

                                        $rating = $review->rating;
                                         if(!empty($rating)){
                                    for($i=0; $i<$rating; $i++) {
                                        echo '<li><i class="fa fa-star"></i></li>';
                                    }
                                }else {
                                   echo  $rating =  "N/A";
                                }
                                    ?>
                                
                                </ul>
                                </td>
                                <td><?php 
                                 if(!empty($review->review)){
                                 echo $out = strlen($review->review) > 40 ? substr($review->review,0,40)."..." : $review->review;
                                  }else {
                                    echo $out = "N/A";
                                  } 
                                ?></td>

                                <td>
                                <a href="{{url('admin/carpet-review-detail/'.$review->id)}}" class="btn btn-danger">view</a>
                                 
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