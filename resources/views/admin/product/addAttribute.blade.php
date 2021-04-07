@extends('admin.includes.admin_design')

@section('title') Add New Product -  {{ config('app.name', 'Laravel') }} @endsection


@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Product Attribute</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Product Attribute</li>
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



                            <form action="{{ route('addAttributes', $product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="control-group">
                                    <div class="field_wrapper">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input type="text" name="sku[]" placeholder="SKU"class="form-control"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="size[]" placeholder="Size" class="form-control"/>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="price[]" placeholder="Price" class="form-control"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="stock[]" placeholder="Stock" class="form-control"/>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="javascript:void(0);" class="add_button" title="Add field">
                                                        <img src="{{ asset('public/uploads/default/add-icon.png') }}" width="20px"/></a>
                                                </div>
                                            </div>


                                    </div>
                                </div>

                                <br>
                                <div class="text-right float-left">
                                    <button type="submit" class="btn btn-primary">Add Product Attribute </button>
                                </div>
                            </form>





                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-stripped mb-0">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>SKU</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($productDetails['attributes'] as $attribute)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $attribute->sku }}</td>
                                            <td>{{ $attribute->size }}</td>
                                            <td>{{ $attribute->price }}</td>
                                            <td>{{ $attribute->stock }}</td>
                                            <td>
                                                <a class="btn btn-danger btn-sm deleteRecord" style="color: white" href="javascript:" rel="{{ $attribute->id }}" rel1="delete-attribute">
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

    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="field_wrapper" style="margin-top:5px">  <div class="row"> <div class="col-md-2"> <input type="text" name="sku[]" placeholder="SKU"class="form-control"/> </div> <div class="col-md-3"> <input type="text" name="size[]" placeholder="Size" class="form-control"/> </div> <div class="col-md-2"> <input type="text" name="price[]" placeholder="Price" class="form-control"/> </div> <div class="col-md-3"> <input type="text" name="stock[]" placeholder="Stock" class="form-control"/> </div> <div class="col-md-2"> <a href="javascript:void(0);" class="remove_button" title="Remove field"> <img src="{{ asset('public/uploads/default/remove-icon.png') }}" width="20px"/></a> </div> </div> </div>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>




@endsection
