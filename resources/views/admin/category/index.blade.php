@extends('admin.includes.admin_design')
@section('title') All categories -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">All Categories</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">All Categories</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
                        <a href="{{route('addCategory')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Category</a>
                    </div>

						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-sm-12">
							<div class="card mb-0">
								<div class="card-header">
                                    <H4> Categories</H4>
								</div>
								<div class="card-body">

									<div class="table-responsive">
										<table class="datatable table table-stripped mb-0">
											<thead>
												<tr>
													<th>SN</th>
													<th>Category image</th>
													<th>Category Name</th>
													<th>Category Code</th>
													<th>Main Category</th>
													<th>status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
											@foreach ($categories as $category)
                                            	<tr>
													<td>{{$loop->index+1}}</td>
													<td>@if(!empty($category->image))
                                               <img src="{{ asset('public/uploads/category/'.$category->image) }}" width="50px">
                                           @else
                                               <img src="{{ asset('public/uploads/default/noimg.png') }}" width="50px">
                                           @endif
											</td>
													<td>{{ $category->category_name }}</td>
                                       				<td>{{ $category->category_code }}</td>
                                       				<td> @if($category->parent_id == 0)
                                               Main Category
                                           @else
                                               {{ $category->subCategory->category_name }}
                                           @endif
											</td>
                                       				<td>  @if($category->status == 1)

                                                            <a class="text-success updateCategoryStatus" style="color: white;" href="javascript:" id="category-{{$category->id}}" category_id="{{ $category->id }}">Active</a>
                                                        @else
                                                            <a class="text-danger updateCategoryStatus" style="color: white;" href="javascript:" id="category-{{$category->id}}" category_id="{{ $category->id }}">In Active</a>
                                                        @endif

                                                    </td>

													<td> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#view_category{{$category->id}}">
                                               <i class="fa fa-eye"></i>

                                           </button>
                                           <a href="{{route('editCategory', $category->id)}}">
                                           <button class="btn btn-success btn-sm">
                                               <i class="fa fa-pencil"></i>
                                           </button>
                                           </a>
                                           <a class="btn btn-danger btn-sm deleteRecord" style="color: white" href="javascript:" rel="{{$category->id}}" rel1="delete-category">
                                               <i class="fa fa-trash"></i>
                                           </a>
											</td>
												</tr>
                                                <!-- Add Department Modal -->
                                                <div id="view_category{{$category->id}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $category->category_name }} Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if(!empty($category->image))
                                                                    <img src="{{ asset('public/uploads/category/'.$category->image) }}" width="80px" >
                                                                @else
                                                                    <img src="{{ asset('public/uploads/default/noimg.png') }}" width="80px">
                                                                @endif
                                                                <hr>
                                                                <p><strong>Category Name: </strong>     {{ $category->category_name }}</p>
                                                                <p><strong>Category Code: </strong>     {{ $category->category_code }}</p>
                                                                <p><strong>Category Slug: </strong>     {{ $category->slug }}</p>
                                                                <p><strong>Main Category: </strong>
                                                                    @if($category->parent_id == 0)
                                                                        Main Category
                                                                    @else
                                                                        {{ $category->subCategory->category_name }}
                                                                    @endif
                                                                </p>

                                                                <p><strong>Category Status: </strong>
                                                                    @if($category->status == 1)
                                                                        <span class="badge bg-success" style="color: white;">Active</span>
                                                                    @else
                                                                        <span class="badge bg-danger" style="color: white;">In Active</span>
                                                                    @endif
                                                                </p>
                                                                <p><strong>Category Description: </strong>
                                                                </p>
                                                                <p>
                                                                    {{ $category->description }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Add Department Modal -->



                                            @endforeach
                                            </tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /Page Wrapper -->
@endsection

@section('js')

    <!-- Datatable JS -->
    <script src="{{ asset('public/adminpanel/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/adminpanel/assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(".deleteRecord").click(function () {
            var SITEURL = '{{ URL::to('') }}';
            var id = $(this).attr('rel');
            var deleteFunction = $(this).attr('rel1');
            swal({
                    title: "Are You Sure? ",
                    text: "You will not be able to recover this record again",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete it!"
                },
                function () {
                    window.location.href = SITEURL + "/admin/" + deleteFunction + "/" + id;
                });
        });

    </script>

    <script>
        $(".updateCategoryStatus").click(function (){
            var status = $(this).text();
            var category_id = $(this).attr("category_id");
            $.ajax({
                type: 'post',
                url: '{{ route('updateCategoryStatus') }}',
                data: {status:status, category_id:category_id},
                success: function (resp){
                    if(resp['status'] == 0){
                        $("#category-"+category_id).html(' <a class="text-danger updateCategoryStatus" style="color: white;" href="javascript:" id="category-{{$category->id}}" category_id="{{ $category->id }}">In Active</a>');
                    } else {
                        $("#category-"+category_id).html(' <a class="text-success updateCategoryStatus" style="color: white;" href="javascript:" id="category-{{$category->id}}" category_id="{{ $category->id }}">Active</a>');

                    }
                }, error: function (){
                    alert("Error");
                }
            });
        });
    </script>




@endsection
