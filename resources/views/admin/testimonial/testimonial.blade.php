@extends('admin.includes.admin_design')

@section('title') All Testimonials -  {{ config('app.name', 'Laravel') }} @endsection


@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">All Testimonials</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Testimonials</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('testimonial.add') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Testimonial</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @include('admin.includes._message')

            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">

                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="datatable table table-stripped mb-0">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($testimonials as $testimonial)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('public/uploads/testimonial/'.$testimonial->image) }}" alt="" width="50">
                                            </td>
                                            <td>{{ $testimonial->name }}</td>
                                            <td>{{ $testimonial->position }}</td>
                                            <td>{{ $testimonial->description }}</td>
                                            <td>{{ $testimonial->created_at->diffForHumans() }}</td>

                                            <td>

                                                <a href="{{ route('testimonial.edit', $testimonial->id) }}">
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                </a>
                                                <a class="btn btn-danger btn-sm deleteRecord" style="color: white" href="javascript:" rel="{{ $testimonial->id }}" rel1="delete-testimonial">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                            </td>
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
    </div>
    <!-- /Page Wrapper -->

@endsection

@section('js')
    <!-- Datatable JS -->
    <script src="{{ asset('public/adminpanel/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/adminpanel/assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('public/adminpanel/assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/adminpanel/assets/js/jquery.sweet-alert.custom.js') }}"></script>

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



@endsection
