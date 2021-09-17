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

                <form name="produksi" id="produksi">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ isset($data_order[0]->id) ? $data_order[0]->id : '' }}">

                                <input type="hidden" class="form-control" id="kode_produksi" name="kode_produksi"
                                    value="{{ isset($data_order[0]->kode_produksi) ? $data_order[0]->kode_produksi : '' }}">

                                <div class="form-group">
                                    <label for="product">Product <a class="tn">*</a></label>
                                    <select class="form-control select2" id="product" data-placeholder="Select a product"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="product_id" required>
                                        <option value="" disabled selected>Choose .. </option>
                                        @foreach ($product as $val)
                                            <option value="{{ $val->id }}">{{ $val->kode }} - {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bahan">Bahan <a class="tn">*</a></label>
                                    <select class="form-control select2" id="bahan" data-placeholder="Select a bahan"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="bahan_id" required>
                                        <option value="" disabled selected>Choose .. </option>
                                        @foreach ($bahan as $val)
                                            <option value="{{ $val->id }}">{{ $val->kode }} - {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bidang">Bidang <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="bidang" name="bidang"
                                        aria-describedby="emailHelp" placeholder="Enter bidang"
                                        value="{{ isset($data_order[0]->bidang) ? $data_order[0]->bidang : '' }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pemakaian">Pemakaian <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="pemakaian" name="pemakaian"
                                        aria-describedby="emailHelp" placeholder="Enter pemakaian"
                                        value="{{ isset($data_order[0]->pemakaian) ? $data_order[0]->pemakaian : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_potong_satuan">Harga Potong Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_potong_satuan"
                                        name="harga_potong_satuan" aria-describedby="emailHelp"
                                        placeholder="Enter harga potong satuan"
                                        value="{{ isset($data_order[0]->harga_potong_satuan) ? (int) $data_order[0]->harga_potong_satuan : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jait_satuan">Harga Jait Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_jait_satuan"
                                        name="harga_jait_satuan"
                                        placeholder="Enter harga jait satuan"
                                        value="{{ isset($data_order[0]->harga_jait_satuan) ? explode(' ', $data_order[0]->harga_jait_satuan)[0] : '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga_finishing_satuan">Harga Finishing Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_finishing_satuan"
                                        name="harga_finishing_satuan" aria-describedby="emailHelp"
                                        placeholder="Enter harga finishing satuan"
                                        value="{{ isset($data_order[0]->harga_finishing_satuan) ? $data_order[0]->harga_finishing_satuan : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_aksesoris">Harga Aksesoris <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_aksesoris"
                                        name="harga_aksesoris" aria-describedby="emailHelp" placeholder="Enter aksesoris"
                                        value="{{ isset($data_order[0]->harga_aksesoris) ? (int) $data_order[0]->harga_aksesoris : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_modal_bahan_satuan">Harga Modal Bahan Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_modal_bahan_satuan"
                                        name="harga_modal_bahan_satuan"
                                        placeholder="Enter harga modal bahan satuan"
                                        value="{{ isset($data_order[0]->harga_modal_bahan_satuan) ? explode(' ', $data_order[0]->harga_modal_bahan_satuan)[0] : '' }}"
                                        required>
                                </div>
                            </div>



                            @if ($status != 'edit')
                                <?php $no = 0; ?>
                                <div class="col-md-8">
                                    <div class="container-fluid" id="item{{ $no }}">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="id_order_item"
                                                        name="variants[{{ $no }}][id]" value="">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="size">Size <a class="tn">*</a></label>
                                                            <select class="form-control inputForm" id="size"
                                                                name="variants[{{ $no }}][size]"
                                                                data-placeholder="Select a size"
                                                                data-dropdown-css-class="select2-purple" style="width: 100%"
                                                                required>
                                                                <option value="" disabled selected>Choose ..</option>
                                                                <option value="S">S</option>
                                                                <option value="M">M</option>
                                                                <option value="L">L</option>
                                                                <option value="XL">XL</option>
                                                                <option value="XXL">XXL</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="jumlah_produksi">Jumlah Produksi <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control jumlah_produksi"
                                                                id="jumlah_produksi"
                                                                name="variants[{{ $no }}][jumlah_produksi]"
                                                                aria-describedby="emailHelp"
                                                                placeholder="Enter jumlah produksi" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="items"></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div id="items"></div> --}}
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
                                                                name="variants[{{ $no }}][id]"
                                                                value="{{ $val->id }}">
                                                            <div class="col-md-4">
                                                                {{-- {{ $val->product_id }} --}}
                                                                <div class="form-group">
                                                                    <label for="product">Product <a class="tn">*</a></label>
                                                                    <select class="form-control" id="product"
                                                                        name="variants[{{ $no }}][product]"
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
                                                                        name="variants[{{ $no }}][price]"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Enter price"
                                                                        value="{{ $val->sell_price }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="qty">Quantity <a class="tn">*</a></label>
                                                                    <input type="text" class="form-control qty" id="qty"
                                                                        name="variants[{{ $no }}][qty]"
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
                        <button type="button" class="btn btn-info btn-sm" id="add_order_item">add size
                        </button>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-sm float-right">save and change
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
            $('#product').val('').change();
            $('#bahan').val('').change();
            $('#size').val('').change();
            $("#qty").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
            $("#harga_potong_satuan").mask('000.000.000', {
                reverse: true
            });
            $(".jumlah_produksi").mask('00000000', {
                reverse: true
            });

            var i = 0 + {{ $no }};
            $('#add_order_item').click(function() {
                i++
                $('#items').append(`<div class="row" id="row` + i + `">
                                <input type="hidden" id="id_order_item" name="variants[` +
                    i +
                    `][id]" value="">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="size">Size <a class="tn">*</a></label>
                                        <select class="form-control inputForm" id="size" name="variants[` +
                    i +
                    `][size]" data-placeholder="Select a size" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;" required>
                                            <option value="" disabled selected>Choose ..</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah_produksi">Jumlah Produksi <a class="tn">*</a></label>
                                        <input type="text" class="form-control" id="jumlah_produksi" name="variants[` +
                    i +
                    `][jumlah_produksi]" aria-describedby="emailHelp" placeholder="Enter jumlah_produksi" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" onclick="removerow(` +
                    i + `)"> romove</button>
                                    </div>
                                </div>
                            </div>`);
                mask();
            })
        })

        function removerow(i) {
            $('#row' + i + '').remove();
        }

        function mask() {
            // $('input[id^="jumlah_produksi"]').mask('000000000', {
            //     reverse: true
            // });
            $('input[id^="jumlah_produksi"]').inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
        }

        $('#produksi').submit(function(e) {
            e.preventDefault();
            var dataForm = new FormData(this);

            $.ajax({
                url: "{{ route('produksi.store') }}",
                type: "post",
                data: dataForm,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    call_toast(result);
                    setTimeout(function() {
                        window.location.href = "{{ route('produksi.index') }}";
                    }, 1000);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

    </script>
@endsection
