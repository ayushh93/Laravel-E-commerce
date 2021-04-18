@extends('admin.includes.admin_design')

@section('title') Add New Product Images -  {{ config('app.name', 'Laravel') }} @endsection


@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Product Images</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Product Images</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('product.index') }}" class="btn add-btn"><i class="fa fa-eye"></i> View All Products</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @include('admin.includes._message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Product Name : </strong> {{ $product->product_name }}</p>

                            <br>




                            <form action="{{ route('addAltImage', $product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="control-group">
                                    <label for="image">Upload Images</label>
                                    <div class="controls">
                                        <input type="file" name="image[]" id="image" class="form-control" multiple="multiple">
                                    </div>
                                </div>

                                <br>
                                <div class="text-right float-left">
                                    <button type="submit" class="btn btn-primary">Add Product Image</button>
                                </div>
                            </form>



                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-stripped mb-0">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($productImages as $image)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('public/uploads/product/'.$image->image) }}" alt="" width="100">
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-sm deleteRecord" style="color: white" href="javascript:" rel="{{ $image->id }}" rel1="delete-image">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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
