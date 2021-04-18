@extends('admin.includes.admin_design')
@section('title') All products -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">All Products</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Products</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{route('addProduct')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Products</a>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->
            @include('admin.includes._message')

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
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>
                                                @if(!empty($product->image))
                                                    <img src="{{ asset('public/uploads/product/'.$product->image) }}" width="50px">
                                                @else
                                                    <img src="{{ asset('public/uploads/default/noimg.png') }}" width="50px">
                                                @endif

                                            </td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->category->category_name  }}</td>
                                            <td>
                                                @if($product->status == 1)
                                                    <a class="text-success updateProductStatus" style="color: white;" href="javascript:" id="product-{{$product->id}}" product_id="{{ $product->id }}">Active</a>
                                                @else
                                                    <a class="text-danger updateProductStatus" style="color: white;" href="javascript:" id="product-{{$product->id}}" product_id="{{ $product->id }}">In Active</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('addAttributes',$product->id)}}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a href="{{route('addAltImage',$product->id)}}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a href="{{route('editProduct',  $product->id)}}">
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                </a>
                                                <a class="btn btn-danger btn-sm deleteRecord" style="color: white" href="javascript:" rel="{{ $product->id }}" rel1="delete-product">
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
        $(".updateProductStatus").click(function (){
            var status = $(this).text();
            var product_id = $(this).attr("product_id");
            $.ajax({
                type: 'post',
                url: '{{ route('updateProductStatus') }}',
                data: {status:status, product_id:product_id},
                success: function (resp){
                    if(resp['status'] == 0){
                        $("#product-"+product_id).html(' <a class="text-danger updateProductStatus" style="color: white;" href="javascript:" id="product-{{$product->id}}" product_id="{{ $product->id }}">In Active</a>');
                    } else {
                        $("#product-"+product_id).html(' <a class="text-success updateProductStatus" style="color: white;" href="javascript:" id="product-{{$product->id}}" product_id="{{ $product->id }}">Active</a>');

                    }
                }, error: function (){
                    alert("Error");
                }
            });
        });
    </script>




@endsection
