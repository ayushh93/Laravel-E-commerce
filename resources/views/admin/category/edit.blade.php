@extends('admin.includes.admin_design')
@section('title')Edit Category -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Categories</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Categories</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('category.index') }}" class="btn add-btn"><i class="fa fa-eye"></i> View all Category</a>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->
            @include('admin.includes._message')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('updateCategory',$myCategory->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category_name">Under Category</label>
                                                <select class="select form-control" name="parent_id">
                                                    <option selected disabled>Select Category</option>
                                                    <option value="0" @if($myCategory->parent_id==0) selected @endif> Main Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" @if($myCategory->parent_id==$category->id) selected @endif>{{ $category->category_name }}</option>
                                                    @endforeach

                                                    <option value=""></option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category_name">Category Name</label>
                                                <input type="text" class="form-control" name="category_name" id="category_name" value="{{$myCategory->category_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category_code">Category Code</label>
                                                <input type="text" class="form-control" name="category_code" id="category_code" value="{{$myCategory->category_code}}">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="image">Profile Image </label>
                                                <input type="hidden" name="current_image" value="{{ $myCategory->image }}">
                                                <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="readURL(this);">
                                            </div>
                                            @if(!empty($myCategory->image))
                                                <img src="{{ asset('public/uploads/category/'.$myCategory->image) }}" width="80px" id="one">
                                            @else
                                                <img src="{{ asset('public/uploads/default/noimg.png') }}" width="80px" id="one">
                                            @endif


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Category Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$myCategory->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" name="status" @if($myCategory->status==1) checked @endif>
                                                <label class="form-check-label" for="invalidCheck">
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right float-left">
                                    <button type="submit" class="btn btn-primary" style="margin-top:20px; "">Update Category</button>
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


@endsection
