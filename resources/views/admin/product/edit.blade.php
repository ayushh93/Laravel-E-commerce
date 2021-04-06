@extends('admin.includes.admin_design')
@section('title')Edit Product -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">Edit Products</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">All Products</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
                        <a href="{{route('product.index')}}" class="btn add-btn"><i class="fa fa-eye"></i> View all Products</a>
                    </div>

						</div>
					</div>
					<!-- /Page Header -->
                    @include('admin.includes._message')
                    <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{Route('updateProduct',$product->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category_name">Under Category</label>
                                                <select class="select form-control" name="category_id">
                                                    @php echo $categories_dropdown;  @endphp


                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="product_name">Product Name</label>
                                                <input type="text" class="form-control" name="product_name" id="product_name" value="{{$product->product_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="price">Product Price</label>
                                                <input type="number" class="form-control" name="price" id="price" value="{{$product->price}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="excerpt">Product Excerpt</label>
                                                <textarea name="excerpt" id="excerpt" cols="30" rows="4" class="form-control" >{{$product->excerpt}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="image">Featured Image </label>
                                                <input type="hidden" name="current_image" value="{{ $product->image }}">
                                                <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="readURL(this);">
                                            </div>
                                            @if(!empty($product->image))
                                                <img src="{{ asset('public/uploads/product/'.$product->image) }}" width="80px" id="one">
                                            @else
                                                <img src="{{ asset('public/uploads/default/noimg.png') }}" width="80px" id="one">
                                            @endif
                                        </div>


                                    </div>
                                    <div class="col-md-6">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Product Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control editor1">{{$product->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">

                                                <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" name="status" @if($product->status==1) checked @endif>
                                                <label class="form-check-label" for="invalidCheck">
                                                    Active
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" name="featured_product" @if($product->featured_product==1) checked @endif>
                                                <label class="form-check-label" for="invalidCheck">
                                                    Mark as Featured Product
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right float-left">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </form>

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
        function readURL(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#one')
                        .attr('src', e.target.result)
                        .width(100)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    //follow thi page for ckeditor
    //https://medium.com/@namandhuri01/how-to-handle-file-upload-in-ckeditor-laravel-6283e93fe6de
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>



@endsection
