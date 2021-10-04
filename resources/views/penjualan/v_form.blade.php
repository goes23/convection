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
                                        value="{{ isset($data_order[0]->kode_pesanan) ? $data_order[0]->kode_pesanan : '' }}"
                                        required>
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
                                    <div class="container-fluid cont" id="item{{ $no }}">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                Product
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="id{{ $no }}"
                                                        name="orderitem[{{ $no }}][id]" value="">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="product">Nama Product <a
                                                                    class="tn">*</a></label>
                                                            <select class="form-control selectp" id="{{ $no }}"
                                                                onchange="pilih_product(this)"
                                                                name="orderitem[{{ $no }}][product]"
                                                                data-placeholder="Select a product"
                                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                                {{-- onchange="product($(this))" --}} required>
                                                                <option value="" disabled>choose ..</option>
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
                                                            <label for="harga_jual">Harga Jual Product <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control harga_jual"
                                                                id="harga_jual{{ $no }}"
                                                                name="orderitem[{{ $no }}][harga_jual]"
                                                                placeholder="0" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="size">Size <a class="tn">*</a></label>
                                                            <select class="form-control select3"
                                                                id="size-{{ $no }}" onchange="pilih_size(this)"
                                                                name="orderitem[{{ $no }}][size]"
                                                                data-placeholder="Select a size"
                                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                                required>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered mysize{{ $no }}"
                                                        id="mysize{{ $no }}">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Size</th>
                                                                <th scope="col">Stock Product</th>
                                                                <th scope="col">qty input</th>
                                                                <th scope="col">Harga jual akhir</th>
                                                                <th scope="col">Keterangan</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="items"></div>
                                </div>
                            @else


                            @endif
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add_order_item">Tambah product
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
            $('.selectp').val('')
            $('.harga_jual').val('');
            mask()

            var pr = 0 + {{ $no }};
            $('#add_order_item').click(function() {
                pr++
                $('#items').append(`<div class="container-fluid cont" id="item` + pr + `">
                    <div class="card card-secondary">
                        <div class="card-header">
                            Product
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" onclick="removeitem(` + pr + `)" style="margin-top: -1px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" id="id_order_item" name="orderitem[` + pr + `][id]" value="">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="product">Nama Product <a class="tn">*</a></label>
                                        <select class="form-control selectp" id="` + pr +
                    `"  onchange="pilih_product(this)" name="orderitem[` +
                    pr + `][product]" data-placeholder="Select a product" data-dropdown-css-class="select2-purple" style="width: 100%;"
                                            required>
                                            <option value="" disabled>choose ..</option>
                                            @foreach ($product as $val)
                                                <option value="{{ $val->id }}"> {{ $val->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual Product <a
                                                class="tn">*</a></label>
                                        <input type="text" class="form-control harga_jual"
                                            id="harga_jual` + pr + `"
                                            name="orderitem[` + pr + `][harga_jual]" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="size">Size <a class="tn">*</a></label>
                                        <select class="form-control select3"
                                            id="size-` + pr + `"
                                            onchange="pilih_size(this)"
                                            name="orderitem[` + pr + `][size]"
                                            data-placeholder="Select a size"
                                            data-dropdown-css-class="select2-purple" style="width: 100%"
                                            required>
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-bordered mysize` + pr + `"
                                    id="mysize` + pr + `">
                                    <thead>
                                        <tr>
                                            <th scope="col">Size</th>
                                            <th scope="col">Stock Product</th>
                                            <th scope="col">qty input</th>
                                            <th scope="col">Harga jual akhir</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>`)
                $('#' + pr).val('')
            })
        })

        function pilih_product(param) {
            var iterasi = param.id
            var id = param.value;
            var urls = "{{ route('penjualan.getdata') }}";
            var product = [];
            var cek = true;
            $('.selectp').not(this).each(function() {
                if (product.includes(this.value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Product sudah di pilih',
                    })
                    $('#harga_jual1').val('')
                    $('#size-1').val('')
                    $(this).val('')
                    cek = false
                } else {
                    product.push(this.value)
                }

            })
            if (cek == true) {
                $.ajax({
                    url: urls,
                    type: "POST",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(result) {
                        $('#harga_jual' + iterasi).val(result[0].harga_jual)
                        var select = "";
                        select += '<option value="" disabled>choose..</option>'
                        for (var i = 0; i < result.length; i++) {
                            select += '<option value="' + result[i].size + '">' + result[i].size +
                                '</option>';
                        }
                        $('#size-' + iterasi).html(select);
                        $('#size-' + iterasi).val('')

                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            }
        }
        var td = [];

        function pilih_size(params) {
            var i = 0;
            $('.select3').on('change', function() {
                i++
            })
            var id_pr = params.id.split("-")[1];
            if (td.includes(params.value + id_pr)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ukuran sudah di pilih',
                })
                return false
            } else {
                td.push(params.value + id_pr)
            }

            var idp = $("#" + id_pr).val()
            var size = params.value;
            if (idp != '' && size != '') {
                $.ajax({
                    url: "{{ route('penjualan.variant') }}",
                    type: "post",
                    data: {
                        id: idp,
                        size: size
                    },
                    dataType: "json",
                    success: function(result) {

                        $('#mysize' + id_pr).append(`<tr id="sz` + id_pr + i + `">
                            <td>
                                <input type="text" class="form-control sizee"
                                    name="orderitem[` + id_pr + `][variant][` + i + `][size]"
                                    value="` + size + `"
                                    placeholder="0" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control qty_product"
                                    id="qty_product-` + id_pr + i + `"
                                    name="orderitem[` + id_pr + `][variant][` + i + `][qty_product]"
                                    placeholder="0" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control qty"
                                    name="orderitem[` + id_pr + `][variant][` + i + `][qty]"
                                    placeholder="Enter quantity" required>
                            </td>
                            <td>
                                <input type="text" class="form-control sell_price"
                                    name="orderitem[` + id_pr + `][variant][` + i + `][sell_price]"
                                    placeholder="Enter harga jual akhir" required>
                            </td>
                            <td>
                                <textarea class="form-control keterangan"
                                    name="orderitem[` + id_pr + `][variant][` + i + `][keterangan]"
                                    rows="3"></textarea>
                            </td>
                            <td> <button type="button" class="btn btn-danger btn-sm" onclick="removesize(` +
                            id_pr + `,` + i + `)">remove</button></td>
                        </tr>`);
                        $("#qty_product-" + id_pr + i).val(result.jumlah_stock_product)
                        removesize()
                        mask()
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });

            } else {
                return false
            }
        }

        function removeitem(i) {
            $('#item' + i + '').remove();
        }

        function removesize(id, i) {
            $('#sz' + id + i + '').remove();
        }


        $('#order').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('penjualan.store') }}",
                type: "post",
                data: $('#order').serialize(),
                dataType: "json",
                success: function(result) {
                    if (result.status == false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.msg,
                        })
                        return false;
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


        function mask() {
            $(".qty").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#shipping_price").mask('000.000.000', {
                reverse: true
            });

            $(".sell_price").mask('000.000.000', {
                reverse: true
            });

            $('input[id^="sell_price"]').mask('000.000.000', {
                reverse: true
            });

            $('input[id^="qty"]').inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $('input[id^="customer_phone"]').inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
        }
    </script>
@endsection
