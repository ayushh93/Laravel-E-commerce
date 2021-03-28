@extends('admin.includes.admin_design_v2')

@section('title') Theme Settings -  {{ config('app.name', 'Laravel') }} @endsection


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
                                <h3 class="page-title">Theme Settings</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    @include('admin.includes._message')

                    <form method="post" action="{{ROUTE('themeUpdate',$theme->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Site Title</label>
                            <div class="col-lg-9">
                                <input name="site_title" class="form-control" type="text" value="{{$theme->site_title }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Site SubTitle</label>
                            <div class="col-lg-9">
                                <input name="site_subtitle" class="form-control" type="text" value="{{$theme->site_subtitle }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Logo</label>
                            <div class="col-lg-7">
                                <input class="form-control" type="file" id="logo" name="logo" accept="image/*" onchange="readURL(this);">
                            </div>
                            <div class="col-lg-2">
                                <div class="img-thumbnail float-right">
                                    <img src="{{ asset('public/uploads/'.$theme->logo) }}" alt="" width="100" height="40" id="one">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Favicon</label>
                            <div class="col-lg-7">
                                <input class="form-control" type="file" id="favicon" name="favicon" accept="image/*" onchange="readURL2(this);">

                            </div>
                            <div class="col-lg-2">
                                <div class="settings-image img-thumbnail float-right">
                                    <img src="{{ asset('public/uploads/'.$theme->favicon) }}" class="img-fluid" width="16" height="16" alt="" id="two"></div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Update</button>
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

    <script>
        function readURL2(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#two')
                        .attr('src', e.target.result)
                        .width(100)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
