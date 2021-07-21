@extends('layout.v_template')

<link rel="stylesheet" href="{{ asset('assets/') }}/main.css">
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $h1 }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('order_header.index') }}">{{ $breadcrumb_item }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $breadcrumb_item_active }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">{{ $card_title }}</h3>
                </div>
                <!-- /.card-header -->
                <form name="order" id="order">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" id="id" name="id" value="">
                                <div class="form-group">
                                    <label for="customer_name">Customer Name <a class="tn">*</a></label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        aria-describedby="emailHelp" placeholder="Enter customer name" required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone">Customer Phone <a class="tn">*</a></label>
                                    <input type="text" class="form-control" id="customer_phome" name="customer_phome"
                                        aria-describedby="emailHelp" placeholder="Enter customer phone">
                                </div>
                                <div class="form-group">
                                    <label for="customer_address">Customer Address <a class="tn">*</a></label>
                                    <input type="text" class="form-control" id="customer_address" name="customer_address"
                                        aria-describedby="emailHelp" placeholder="Enter customer address" >
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="channel">Channel <a class="tn">*</a></label>
                                    <select class="form-control select2" id="channel" name="channel"
                                        data-placeholder="Select a channel" data-dropdown-css-class="select2-purple"
                                        style="width: 100%" required>
                                        @foreach ($channel as $val)
                                            <option value="{{ $val->id }}"> {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date <a class="tn">*</a></label>
                                    <input type="date" class="form-control inputForm" id="purchase_date"
                                        name="purchase_date" name="purchase_date" aria-describedby="emailHelp"
                                        placeholder="Enter purchase date" required>
                                </div>
                                <div class="form-group">
                                    <label for="shipping_price">Shipping Price <a class="tn">*</a></label>
                                    <input type="text" class="form-control" id="shipping_price" name="shipping_price"
                                        aria-describedby="emailHelp" placeholder="Enter shipping price" required>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="container-fluid" id="item">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="product">Product <a class="tn">*</a></label>
                                                        <select class="form-control select2" id="product" name="orderitem[0][product]"
                                                            data-placeholder="Select a product"
                                                            data-dropdown-css-class="select2-purple" style="width: 100%"
                                                            required>
                                                            @foreach ($product as $val)
                                                                <option value="{{ $val->id }}"> {{ $val->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="price">Price <a class="tn">*</a></label>
                                                        <input type="text" class="form-control price" id="price"
                                                            name="orderitem[0][price]" aria-describedby="emailHelp"
                                                            placeholder="Enter price" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="qty">Quantity <a class="tn">*</a></label>
                                                        <input type="text" class="form-control qty" id="qty" name="orderitem[0][qty]"
                                                            aria-describedby="emailHelp" placeholder="Enter quantity"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="items"></div>
                            </div>

                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add_order_item">add order item
                        </button>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-sm float-right">save order
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            var i = 0;
            $("#qty").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#shipping_price").mask('000.000.000', {
                reverse: true
            });

            $("#price").mask('000.000.000', {
                reverse: true
            });

            $('#add_order_item').click(function() {
                i++
                $('#items').append(`<div class="container-fluid" id="item` + i + `">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" onclick="removeitem(` + i + `)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="product">Product <a class="tn">*</a></label>
                                                        <select class="form-control select2" id="product" name="orderitem[`+i+`][product]"
                                                            data-placeholder="Select a product" data-dropdown-css-class="select2-purple"
                                                            style="width: 100%;" required>
                                                            @foreach ($product as $val)
                                                                <option value="{{ $val->id }}"> {{ $val->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="price">Price <a class="tn">*</a></label>
                                                        <input type="text" class="form-control" id="price" name="orderitem[`+i+`][price]" aria-describedby="emailHelp"
                                                            placeholder="Enter price" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="qty">Quantity <a class="tn">*</a></label>
                                                        <input type="text" class="form-control qty" id="qty" name="orderitem[`+i+`][qty]" aria-describedby="emailHelp"
                                                            placeholder="Enter quantity" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                mask();
            })
        })

        function removeitem(i) {
            $('#item' + i + '').remove();
        }

        function mask() {
            $('input[id^="price"]').mask('000.000.000', {
                reverse: true
            });
            $('input[id^="qty"]').inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
        }

        $('#order').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('order_header.store') }}",
                type: "post",
                data: $('#order').serialize(),
                dataType: "json",
                success: function(result) {
                    console.log(result);
                   call_toast(result);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

    </script>
@endsection;
