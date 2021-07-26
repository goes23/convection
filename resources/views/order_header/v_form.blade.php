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
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ isset($data_order[0]->id) ? $data_order[0]->id : '' }}">
                                <input type="hidden" class="form-control" id="purchase_code" name="purchase_code"
                                    value="{{ isset($data_order[0]->purchase_code) ? $data_order[0]->purchase_code : '' }}">
                                <div class="form-group">
                                    <label for="customer_name">Customer Name <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="customer_name"
                                        name="customer_name" aria-describedby="emailHelp" placeholder="Enter customer name"
                                        value="{{ isset($data_order[0]->customer_name) ? $data_order[0]->customer_name : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone">Customer Phone <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="customer_phone"
                                        name="customer_phone" aria-describedby="emailHelp"
                                        placeholder="Enter customer phone"
                                        value="{{ isset($data_order[0]->customer_phone) ? $data_order[0]->customer_phone : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="customer_address">Customer Address <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="customer_address"
                                        name="customer_address" aria-describedby="emailHelp"
                                        placeholder="Enter customer address"
                                        value="{{ isset($data_order[0]->customer_address) ? $data_order[0]->customer_address : '' }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="channel">Channel <a class="tn">*</a></label>
                                    <select class="form-control inputForm" id="channel" name="channel" style="width: 100%"
                                        required>
                                        @foreach ($channel as $key => $valu)
                                            <?php
                                            $option = '';
                                            if(isset($data_order[0]->channel_id)){
                                                if ( $data_order[0]->channel_id == $valu->id) {
                                                $option = "selected=selected";
                                                }
                                            }?>
                                            <option value="{{ $valu->id }}" <?php echo $option;?>>
                                                {{ $valu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shipping_price">Shipping Price <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="shipping_price"
                                        name="shipping_price" aria-describedby="emailHelp"
                                        placeholder="Enter shipping price"
                                        value="{{ isset($data_order[0]->shipping_price) ? (int) $data_order[0]->shipping_price : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date <a class="tn">*</a></label>
                                    <input type="date" class="form-control inputForm" id="purchase_date"
                                        name="purchase_date" name="purchase_date" placeholder="Enter purchase date"
                                        value="{{ isset($data_order[0]->purchase_date) ? explode(' ', $data_order[0]->purchase_date)[0] : '' }}"
                                        required>
                                </div>
                            </div>
                            @if ($status != 'edit')
                                <?php $no = 0; ?>
                                <div class="col-md-12">
                                    <div class="container-fluid" id="item{{ $no }}">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="id_order_item"
                                                        name="orderitem[{{ $no }}][id]" value="">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="product">Product <a class="tn">*</a></label>
                                                            <select class="form-control inputForm" id="product"
                                                                name="orderitem[{{ $no }}][product]"
                                                                data-placeholder="Select a product"
                                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                                required>
                                                                @foreach ($product as $val)
                                                                    <option value="{{ $val->id }}">
                                                                        {{ $val->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="price">Price <a class="tn">*</a></label>
                                                            <input type="text" class="form-control price" id="price"
                                                                name="orderitem[{{ $no }}][price]"
                                                                aria-describedby="emailHelp" placeholder="Enter price"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="qty">Quantity <a class="tn">*</a></label>
                                                            <input type="text" class="form-control qty" id="qty"
                                                                name="orderitem[{{ $no }}][qty]"
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
                            @else
                                @foreach ($data_order as $item)
                                    <?php $no = 0; ?>
                                    @foreach ($item->order_item as $val)
                                        <div class="col-md-12">
                                            <div class="container-fluid"
                                                id="item<?php echo $no; ?>">
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                onclick="removeitem(<?php echo $no; ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <input type="hidden" id="id_order_item"
                                                                name="orderitem[{{ $no }}][id]"
                                                                value="{{ $val->id }}">
                                                            <div class="col-md-4">
                                                                {{-- {{ $val->product_id }} --}}
                                                                <div class="form-group">
                                                                    <label for="product">Product <a class="tn">*</a></label>
                                                                    <select class="form-control" id="product"
                                                                        name="orderitem[{{ $no }}][product]"
                                                                        data-placeholder="Select a product"
                                                                        style="width: 100%" required>
                                                                        @foreach ($product as $vals)
                                                                            <option value="{{ $vals->id }}"
                                                                                {{ (int) $val->product_id == (int) $vals->id ? 'selected=selected' : '' }}>
                                                                                {{ $vals->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="price">Price <a class="tn">*</a></label>
                                                                    <input type="text" class="form-control price" id="price"
                                                                        name="orderitem[{{ $no }}][price]"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Enter price"
                                                                        value="{{ $val->sell_price }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="qty">Quantity <a class="tn">*</a></label>
                                                                    <input type="text" class="form-control qty" id="qty"
                                                                        name="orderitem[{{ $no }}][qty]"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Enter quantity"
                                                                        value="{{ $val->qty }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $no++; ?>
                                    @endforeach
                                    <div class="col-md-12">
                                        <div id="items"></div>
                                    </div>
                                @endforeach

                            @endif
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
            var i = 0 + {{ $no }};
            $("#qty").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#shipping_price").mask('000.000.000', {
                reverse: true
            });

            $(".price").mask('000.000.000', {
                reverse: true
            });

            $('#add_order_item').click(function() {
                i++
                $('#items').append(`<div class="container-fluid" id="item` + i + `">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" onclick="removeitem(` +
                                                        i +
                                                        `)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="id_order_item" name="orderitem[` +
                                                        i +
                                                        `][id]" value="">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="product">Product <a class="tn">*</a></label>
                                                            <select class="form-control inputForm" id="product" name="orderitem[` +
                                                        i +
                                                        `][product]" data-placeholder="Select a product" data-dropdown-css-class="select2-purple"
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
                                                            <input type="text" class="form-control" id="price" name="orderitem[` +
                                                        i +
                                                        `][price]" aria-describedby="emailHelp" placeholder="Enter price" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="qty">Quantity <a class="tn">*</a></label>
                                                            <input type="text" class="form-control qty" id="qty" name="orderitem[` +
                                                        i +
                                                        `][qty]" aria-describedby="emailHelp" placeholder="Enter quantity" required>
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
                    setTimeout(function() {
                        window.location.href = "{{ route('order_header.index') }}";
                    }, 1000);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

    </script>
@endsection
