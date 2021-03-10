@extends('admin.includes.admin_design')
@section('title') Admin Profile -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">

<!-- Page Content -->
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Admin Profile Settings</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

            <form method="post" action="{{route('updateProfile', $admin->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name" value="{{$admin->name}}">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" id="email" name="email" value="{{$admin->email}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="phone" name="phone" value="{{$admin->phone}}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input class="form-control" type="address" id="address" name="address" value="{{$admin->address}}">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="image">Profile Image </label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="readURL(this);">
                        </div>
                        

                        <img src="{{asset('public/uploads/admin/' . $admin->image )}}" style="width: 100px" id="one">
                    </div>

                </div>

                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

@endsection

@section('js')
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