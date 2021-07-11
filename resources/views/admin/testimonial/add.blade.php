@extends('admin.includes.admin_design')

@section('title') Add New Testimonial -  {{ config('app.name', 'Laravel') }} @endsection


@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Testimonial</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Testimonial</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('testimonial.index') }}" class="btn add-btn"><i class="fa fa-eye"></i> View All Testimonials</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @include('admin.includes._message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('testimonial.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="position">Position</label>
                                                <input type="text" class="form-control" name="position" id="position" value="{{ old('position') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="image"> Image </label>
                                                <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="readURL(this);">
                                            </div>
                                            <img src="" style="width: 100px" id="one">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description"> Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="text-right float-left">
                                    <button type="submit" class="btn btn-primary">Add Testimonial</button>
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
