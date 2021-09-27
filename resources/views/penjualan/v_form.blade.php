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
                        <li class="breadcrumb-item"><a href="{{ route('penjualan.index') }}">{{ $breadcrumb_item }}</a>
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
                                        name="customer_name" placeholder="Enter customer name"
                                        value="{{ isset($data_order[0]->customer_name) ? $data_order[0]->customer_name : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone">Customer Phone <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="customer_phone"
                                        name="customer_phone" placeholder="Enter customer phone"
                                        value="{{ isset($data_order[0]->customer_phone) ? $data_order[0]->customer_phone : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="customer_address">Customer Address <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="customer_address"
                                        name="customer_address" placeholder="Enter customer address"
                                        value="{{ isset($data_order[0]->customer_address) ? $data_order[0]->customer_address : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="kode_pesanan">Kode Pesanan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="kode_pesanan" name="kode_pesanan"
                                        placeholder="Enter kode pesanan"
                                        value="{{ isset($data_order[0]->kode_pesanan) ? $data_order[0]->kode_pesanan : '' }}">
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
                                            if (isset($data_order[0]->channel_id)) {
                                                if ($data_order[0]->channel_id == $valu->id) {
                                                    $option = 'selected=selected';
                                                }
                                            } ?>
                                            <option value="{{ $valu->id }}" <?php echo $option; ?>>
                                                {{ $valu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shipping_price">Shipping Price <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="shipping_price"
                                        name="shipping_price" placeholder="Enter shipping price"
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
                            @if ($status != 1)
                                <?php $no = 0; ?>
                                <div class="col-md-12">
                                    <div class="container-fluid" id="item{{ $no }}">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="id{{ $no }}"
                                                        name="orderitem[{{ $no }}][id]" value="">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="product">Product <a
                                                                    class="tn">*</a></label>
                                                            <select class="form-control select2" id="{{ $no }}"
                                                                name="orderitem[{{ $no }}][product]"
                                                                data-placeholder="Select a product"
                                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                                {{-- onchange="product($(this))" --}} required>
                                                                <option value="">choose ..</option>
                                                                @foreach ($product as $val)
                                                                    <option value="{{ $val->id }}">
                                                                        {{ $val->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="harga_jual">Harga Jual <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control harga_jual"
                                                                id="harga_jual{{ $no }}"
                                                                name="orderitem[{{ $no }}][harga_jual]" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="size">Size <a class="tn">*</a></label>
                                                            <select class="form-control select3"
                                                                id="size{{ $no }}"
                                                                name="orderitem[{{ $no }}][size]"
                                                                data-placeholder="Select a size"
                                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                                required>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="qty_product">Quantity product<a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control qty_product"
                                                                id="qty_product{{ $no }}"
                                                                name="orderitem[{{ $no }}][qty_product]"
                                                                placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="qty">Quantity <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control qty" id="qty"
                                                                name="orderitem[{{ $no }}][qty]"
                                                                placeholder="Enter quantity" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="sell_price">Harga jual akhir <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control sell_price"
                                                                id="sell_price{{ $no }}"
                                                                name="orderitem[{{ $no }}][sell_price]"
                                                                placeholder="Enter harga jual akhir" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan <a
                                                                    class="tn">*</a></label>
                                                            <textarea class="form-control keterangan"
                                                                name="orderitem[{{ $no }}][keterangan]"
                                                                id="keterangan{{ $no }}" rows="3"></textarea>
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
                                    @foreach ($item->item_penjualan as $val)
                                        <div class="col-md-12">
                                            <div class="container-fluid" id="item<?php echo $no; ?>">
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
                                                            <div class="col-md-3">
                                                                {{-- {{ $val->product_id }} --}}
                                                                <div class="form-group">
                                                                    <label for="product">Product <a
                                                                            class="tn">*</a></label>
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
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="harga_jual">Harga Jual <a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control harga_jual"
                                                                        id="harga_jual{{ $no }}"
                                                                        name="orderitem[{{ $no }}][harga_jual]"
                                                                        value="{{$val->harga_jual}}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="size">Size <a
                                                                            class="tn">*</a></label>
                                                                    <select class="form-control select3"
                                                                        id="size{{ $no }}"
                                                                        name="orderitem[{{ $no }}][size]"
                                                                        data-placeholder="Select a size"
                                                                        data-dropdown-css-class="select2-purple"
                                                                        style="width: 100%" required>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="qty_product">Quantity product<a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control qty_product"
                                                                        id="qty_product{{ $no }}"
                                                                        name="orderitem[{{ $no }}][qty_product]"
                                                                        placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="qty">Quantity <a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control qty" id="qty"
                                                                        name="orderitem[{{ $no }}][qty]"
                                                                        placeholder="Enter quantity" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sell_price">Harga jual akhir <a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control sell_price"
                                                                        id="sell_price{{ $no }}"
                                                                        name="orderitem[{{ $no }}][sell_price]"
                                                                        placeholder="Enter harga jual akhir" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="keterangan">Keterangan <a
                                                                            class="tn">*</a></label>
                                                                    <textarea class="form-control keterangan"
                                                                        name="orderitem[{{ $no }}][keterangan]"
                                                                        id="keterangan{{ $no }}"
                                                                        rows="3"></textarea>
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
            if ({{ $status }} == 0) {
                $('.select2').val('')
            }
            var i = 0 + {{ $no }};
            $("#qty").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#shipping_price").mask('000.000.000', {
                reverse: true
            });

            $(".sell_price").mask('000.000.000', {
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
                                    <input type="hidden" id="id_order_item" name="orderitem[` + i + `][id]" value="">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="product">Product <a class="tn">*</a></label>
                                            <select class="form-control select2" id="` + i + `" name="orderitem[` + i + `][product]" data-placeholder="Select a product" data-dropdown-css-class="select2-purple" style="width: 100%;"
                                                required>
                                                <option value="">choose ..</option>
                                                @foreach ($product as $val)
                                                    <option value="{{ $val->id }}"> {{ $val->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="harga_jual">Harga Jual <a
                                                    class="tn">*</a></label>
                                            <input type="text" class="form-control harga_jual"
                                                id="harga_jual` + i + `"
                                                name="orderitem[` + i + `][harga_jual]" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="size">Size <a class="tn">*</a></label>
                                            <select class="form-control select3"
                                                id="size` + i + `"
                                                name="orderitem[` + i + `][size]"
                                                data-placeholder="Select a size"
                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                required>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="qty_product">Quantity product<a
                                                    class="tn">*</a></label>
                                            <input type="text" class="form-control qty_product"
                                                id="qty_product` + i + `"
                                                name="orderitem[` + i + `][qty_product]"
                                                placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="qty">Quantity <a
                                                    class="tn">*</a></label>
                                            <input type="text" class="form-control qty" id="qty"
                                                name="orderitem[` + i + `][qty]"
                                                placeholder="Enter quantity" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sell_price">Harga jual akhir <a
                                                    class="tn">*</a></label>
                                            <input type="text" class="form-control sell_price"
                                                id="sell_price` + i + `"
                                                name="orderitem[` + i + `][sell_price]"
                                                placeholder="Enter harga jual akhir" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan <a
                                                    class="tn">*</a></label>
                                            <textarea class="form-control keterangan"
                                                id="keterangan` + i + `" rows="3"></textarea>
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
            $('input[id^="sell_price"]').mask('000.000.000', {
                reverse: true
            });

            $('input[id^="qty"]').inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
        }

        $('#order').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('penjualan.store') }}",
                type: "post",
                data: $('#order').serialize(),
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    return false
                    if (result.status == false) {
                        alert(result.msg)
                        return false
                    } else {
                        call_toast(result);
                        setTimeout(function() {
                            window.location.href = "{{ route('penjualan.index') }}";
                        }, 1000);

                    }
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

        $('.select2').on('change', function() {
            console.log("ok");
            var id = $(this).val();
            var iterasi = $(this).attr('id');
            if (id != "") {
                $.ajax({
                    url: id + "/get_data_product",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $('#harga_jual' + iterasi).val(result[0].harga_jual)
                        var select = "";
                        select += '<option value="">choose..</option>'
                        for (var i = 0; i < result.length; i++) {
                            select += '<option value="' + result[i].v_id + '">' + result[i].size +
                                '</option>';
                        }
                        $('#size' + iterasi).html(select);

                        $('#size' + iterasi).on('change', function() {
                            var value = $(this).val();
                            var qty_prod = 0;
                            for (let n = 0; n < result.length; n++) {
                                if (parseInt(result[n].v_id) == parseInt(value)) {
                                    $('#qty_product' + iterasi).val(result[n]
                                        .jumlah_stock_product)
                                    break;
                                }

                            }
                        })

                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            } else {
                $('#harga_jual' + iterasi).val('')
                $('#size' + iterasi).html('');
                return false;
            }
        });
    </script>
@endsection
