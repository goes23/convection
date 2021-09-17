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
                                    value="{{ isset($data_produksi[0]->id) ? $data_produksi[0]->id : '' }}">

                                <input type="hidden" class="form-control" id="kode_produksi" name="kode_produksi"
                                    value="{{ isset($data_produksi[0]->kode_produksi) ? $data_produksi[0]->kode_produksi : '' }}">
                                <div class="form-group">
                                    <label for="product">Product <a class="tn">*</a></label>
                                    <select class="form-control select2" id="product" data-placeholder="Select a product"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="product_id"
                                        required>
                                        <option value="" disabled selected>Choose .. </option>
                                        @foreach ($product as $val)
                                            @php
                                                $option = '';
                                                if (isset($data_produksi[0]->product_id)) {
                                                    if ($data_produksi[0]->product_id == $val->id) {
                                                        $option = 'selected=selected';
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $val->id }}" @php echo $option; @endphp>{{ $val->kode }} -
                                                {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bahan">Bahan <a class="tn">*</a></label>
                                    <select class="form-control select2" id="bahan" data-placeholder="Select a bahan"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="bahan_id"
                                        required>
                                        <option value="" disabled selected>Choose .. </option>
                                        @foreach ($bahan as $vals)
                                            @php
                                                $option = '';
                                                if (isset($data_produksi[0]->bahan_id)) {
                                                    if ($data_produksi[0]->bahan_id == $vals->id) {
                                                        $option = 'selected=selected';
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $vals->id }}" @php echo $option; @endphp>{{ $vals->kode }} -
                                                {{ $vals->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bidang">Bidang <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="bidang" name="bidang"
                                        aria-describedby="emailHelp" placeholder="Enter bidang"
                                        value="{{ isset($data_produksi[0]->bidang) ? $data_produksi[0]->bidang : '' }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pemakaian">Pemakaian <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="pemakaian" name="pemakaian"
                                        aria-describedby="emailHelp" placeholder="Enter pemakaian"
                                        value="{{ isset($data_produksi[0]->pemakaian) ? $data_produksi[0]->pemakaian : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_potong_satuan">Harga Potong Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_potong_satuan"
                                        name="harga_potong_satuan" aria-describedby="emailHelp"
                                        placeholder="Enter harga potong satuan"
                                        value="{{ isset($data_produksi[0]->harga_potong_satuan) ? (int) $data_produksi[0]->harga_potong_satuan : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jait_satuan">Harga Jait Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_jait_satuan"
                                        name="harga_jait_satuan" placeholder="Enter harga jait satuan"
                                        value="{{ isset($data_produksi[0]->harga_jait_satuan) ? explode(' ', $data_produksi[0]->harga_jait_satuan)[0] : '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga_finishing_satuan">Harga Finishing Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_finishing_satuan"
                                        name="harga_finishing_satuan" aria-describedby="emailHelp"
                                        placeholder="Enter harga finishing satuan"
                                        value="{{ isset($data_produksi[0]->harga_finishing_satuan) ? $data_produksi[0]->harga_finishing_satuan : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_aksesoris">Harga Aksesoris <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_aksesoris"
                                        name="harga_aksesoris" aria-describedby="emailHelp" placeholder="Enter aksesoris"
                                        value="{{ isset($data_produksi[0]->harga_aksesoris) ? (int) $data_produksi[0]->harga_aksesoris : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_modal_bahan_satuan">Harga Modal Bahan Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_modal_bahan_satuan"
                                        name="harga_modal_bahan_satuan" placeholder="Enter harga modal bahan satuan"
                                        value="{{ isset($data_produksi[0]->harga_modal_bahan_satuan) ? explode(' ', $data_produksi[0]->harga_modal_bahan_satuan)[0] : '' }}"
                                        required>
                                </div>
                            </div>


                            @if ($status != 1)
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
                                @foreach ($data_produksi as $item)
                                    <div class="col-md-8">
                                        <div class="container-fluid" id="item">
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                </div>
                                                <div class="card-body">
                                                    <?php $no = 0; ?>
                                                    @foreach ($item->variants as $val)
                                                        <div class="row" id="row{{ $no }}">
                                                            <input type="hidden" id="id_order_item"
                                                                name="variants[{{ $no }}][id]" value="">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="size">Size <a class="tn">*</a></label>
                                                                    <select class="form-control inputForm" id="size"
                                                                        name="variants[{{ $no }}][size]"
                                                                        data-placeholder="Select a size"
                                                                        data-dropdown-css-class="select2-purple"
                                                                        style="width: 100%" value="XXL" required>
                                                                        <option value="">Choose ..
                                                                        </option>
                                                                        <option value="S" @php echo $val->size =='S'?'selected="selected"' : ''; @endphp>S</option>
                                                                        <option value="M" @php echo $val->size =='M' ?'selected="selected"' : ''; @endphp>M</option>
                                                                        <option value="L" @php echo $val->size =='L' ?'selected="selected"' : '' ;@endphp>L</option>
                                                                        <option value="XL" @php echo $val->size =='XL' ?'selected="selected"' : ''; @endphp>XL</option>
                                                                        <option value="XXL" @php echo $val->size =='XXL' ?'selected="selected"' : ''; @endphp>XXL</option>

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
                                                                        placeholder="Enter jumlah produksi"
                                                                        value="{{ $val->jumlah_produksi }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <br>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        style="margin-top: 10px;"
                                                                        onclick="removerow(@php echo $no @endphp)">
                                                                        romove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $no++; @endphp
                                                    @endforeach
                                                    <div id="items"></div>
                                                </div>
                                            </div>
                                        </div>
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
            var status = {{ $status }}
            if (status != 1) {
                $('#product').val('').change();
                $('#bahan').val('').change();
                //$('#size').val('').change();
            }

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
                $('#items').append(`<div class="row" id="row` + i +
                    `">
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
