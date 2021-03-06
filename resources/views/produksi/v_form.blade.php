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

                <form name="produksi" id="produksi">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" class="form-control" id="status" value="" name="status">

                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ isset($data_produksi[0]->id) ? $data_produksi[0]->id : '' }}">

                                <input type="hidden" class="form-control" id="kode_produksi" name="kode_produksi"
                                    value="{{ isset($data_produksi[0]->kode_produksi) ? $data_produksi[0]->kode_produksi : '' }}">

                                <div class="form-group">
                                    <label for="product">Product <a class="tn">*</a></label>
                                    <select class="form-control select2" id="product" data-placeholder="Select a product"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="product_id"
                                        required <?php echo isset($data_produksi[0]->product_id) ? 'disabled="disabled"' : ''; ?>>
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
                                        required <?php echo isset($data_produksi[0]->bahan_id) ? 'disabled="disabled"' : ''; ?>>
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
                                            <option value="{{ $vals->id }}" @php echo $option; @endphp>{{ $vals->kode }}
                                                -
                                                {{ $vals->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($status == 1)
                                    <input type="hidden" class="form-control" id="product_id" name="product_id"
                                        value="{{ $data_produksi[0]->product_id }}">

                                    <input type="hidden" class="form-control" id="bahan_id" name="bahan_id"
                                        value="{{ $data_produksi[0]->bahan_id }}">

                                @endif
                                <div class="form-group">
                                    <label for="panjang">Panjang bahan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="panjang" name="panjang"
                                        placeholder="panjang" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="sisa_bahan">Sisa bahan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="sisa_bahan" name="sisa_bahan"
                                        placeholder="panjang" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="panjang_bahan">Panjang bahan di gunakan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="panjang_bahan"
                                        name="panjang_bahan" placeholder="Enter panjang bahan di gunakan"
                                        value="{{ isset($data_produksi[0]->panjang_bahan) ? $data_produksi[0]->panjang_bahan : '' }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="bidang">Bidang <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="bidang" name="bidang"
                                            placeholder="Enter bidang"
                                            value="{{ isset($data_produksi[0]->bidang) ? $data_produksi[0]->bidang : '' }}">
                                    </div>
                                    <label for="pemakaian">Pemakaian <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="pemakaian" name="pemakaian"
                                        placeholder="Enter pemakaian"
                                        value="{{ isset($data_produksi[0]->pemakaian) ? $data_produksi[0]->pemakaian : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_potong_satuan">Harga Potong Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_potong_satuan"
                                        name="harga_potong_satuan" placeholder="Enter harga potong satuan"
                                        value="{{ isset($data_produksi[0]->harga_potong_satuan) ? (int) $data_produksi[0]->harga_potong_satuan : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jait_satuan">Harga Jahit Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_jait_satuan"
                                        name="harga_jait_satuan" placeholder="Enter harga jait satuan"
                                        value="{{ isset($data_produksi[0]->harga_jait_satuan) ? explode(' ', $data_produksi[0]->harga_jait_satuan)[0] : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_finishing_satuan">Harga Finishing Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_finishing_satuan"
                                        name="harga_finishing_satuan" placeholder="Enter harga finishing satuan"
                                        value="{{ isset($data_produksi[0]->harga_finishing_satuan) ? $data_produksi[0]->harga_finishing_satuan : '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="harga_aksesoris">Harga Aksesoris <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_aksesoris"
                                        name="harga_aksesoris" placeholder="Enter aksesoris"
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
                                <div class="col-md-12">
                                    <div class="container-fluid" id="item{{ $no }}">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="id_order_item"
                                                        name="variants[{{ $no }}][id]" value="">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="size">Size <a class="tn">*</a></label>
                                                            <select class="form-control size" id="size{{ $no }}"
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
                                                                <option value="XXXL">XXXL</option>
                                                                <option value="4XL">4XL</option>
                                                                <option value="5XL">5XL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="jumlah_produksi">Jumlah Produksi <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control jumlah_produksi"
                                                                id="jumlah_produksi{{ $no }}"
                                                                onkeyup="clone({{ $no }})"
                                                                name="variants[{{ $no }}][jumlah_produksi]"
                                                                placeholder="Enter jumlah produksi" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="sisa_jumlah_produksi">Sisa Produksi <a
                                                                    class="tn">*</a></label>
                                                            <input type="text" class="form-control sisa_jumlah_produksi"
                                                                id="sisa_jumlah_produksi{{ $no }}"
                                                                name="variants[{{ $no }}][sisa_jumlah_produksi]"
                                                                placeholder="Enter harga jual" readonly>
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
                                    <div class="col-md-12">
                                        <div class="container-fluid" id="item">
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                </div>
                                                <div class="card-body">
                                                    <?php $no = 0; ?>
                                                    @foreach ($item->variants as $val)

                                                        <div class="row" id="row{{ $no }}">
                                                            <input type="hidden" id="id"
                                                                name="variants[{{ $no }}][id]"
                                                                value="{{ $val->id }}">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="size">Size <a
                                                                            class="tn">*</a></label>
                                                                    <select class="form-control size"
                                                                        id="size{{ $no }}"
                                                                        name="variants[{{ $no }}][size]"
                                                                        data-placeholder="Select a size"
                                                                        data-dropdown-css-class="select2-purple"
                                                                        style="width: 100%" disabled>
                                                                        <option value="">Choose ..
                                                                        </option>
                                                                        <option value="S" @php echo $val->size =='S'?'selected="selected"' : ''; @endphp>S</option>
                                                                        <option value="M" @php echo $val->size =='M' ?'selected="selected"' : ''; @endphp>M</option>
                                                                        <option value="L" @php echo $val->size =='L' ?'selected="selected"' : '' ;@endphp>L</option>
                                                                        <option value="XL" @php echo $val->size =='XL' ?'selected="selected"' : ''; @endphp>XL</option>
                                                                        <option value="XXL" @php echo $val->size =='XXL' ?'selected="selected"' : ''; @endphp>XXL</option>
                                                                        <option value="XXXL" @php echo $val->size =='XXXL' ?'selected="selected"' : ''; @endphp>XXXL</option>
                                                                        <option value="4XL" @php echo $val->size =='4XL' ?'selected="selected"' : ''; @endphp>4XL</option>
                                                                        <option value="5XL" @php echo $val->size =='5XL' ?'selected="selected"' : ''; @endphp>5XL</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="jumlah_produksi">Jumlah Produksi <a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control jumlah_produksi"
                                                                        id="jumlah_produksi"
                                                                        name="variants[{{ $no }}][jumlah_produksi]"
                                                                        placeholder="Enter jumlah produksi"
                                                                        value="{{ $val->jumlah_produksi }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sisa_jumlah_produksi">Sisa Produksi <a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control "
                                                                        id="sisa_jumlah_produksi"
                                                                        name="variants[{{ $no }}][sisa_jumlah_produksi]"
                                                                        placeholder="Enter harga jual"
                                                                        value="{{ $val->sisa_jumlah_produksi }}"
                                                                        readonly>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" class="form-control jumlah_stock_product"
                                                                id="jumlah_stock_product{{ $no }}"
                                                                name="variants[{{ $no }}][jumlah_stock_product]"
                                                                value="{{ $val->jumlah_stock_product }}" readonly>

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
            mask_number();
            select_change();
            var status = {{ $status }}
            $('#status').val(status)
            if (status != 1) {
                $('#product').val('');
                $('#bahan').val('');
                $('#size').val('');
            } else {
                // console.log($('#panjang_bahan').val())
                var val = $('#bahan').val();
                var bahan = <?php echo json_encode($bahan); ?>;
                for (var i = 0; i < bahan.length; i++) {
                    if (parseInt(val) == parseInt(bahan[i].id)) {
                        $('#panjang').val(bahan[i].panjang)
                        $('#sisa_bahan').val(parseInt(bahan[i].sisa_bahan) + parseInt($('#panjang_bahan').val()))
                        break;
                    }
                }
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
                    `][id]" value=""/>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="size">Size <a class="tn">*</a></label>
                                                            <select class="form-control size" id="size` + i +
                    `" name="variants[` +
                    i +
                    `][size]" data-placeholder="Select a size" data-dropdown-css-class="select2-purple" style="width: 100%;"
                                                                required>
                                                                <option value="" disabled selected>Choose ..</option>
                                                                <option value="S">S</option>
                                                                <option value="M">M</option>
                                                                <option value="L">L</option>
                                                                <option value="XL">XL</option>
                                                                <option value="XXL">XXL</option>
                                                                <option value="XXXL">XXXL</option>
                                                                <option value="4XL">4XL</option>
                                                                <option value="5XL">5XL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="jumlah_produksi">Jumlah Produksi <a class="tn">*</a></label>
                                                            <input type="text" class="form-control" id="jumlah_produksi` +
                    i + `" name="variants[` +
                    i +
                    `][jumlah_produksi]" placeholder="Enter jumlah_produksi" onkeyup="clone(` + i + `)" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sisa_jumlah_produksi">Sisa Produksi <a
                                                                            class="tn">*</a></label>
                                                                    <input type="text" class="form-control sisa_jumlah_produksi"
                                                                        id="sisa_jumlah_produksi` + i + `"
                                                                        name="variants[` + i +
                    `][sisa_jumlah_produksi]"
                                                                        placeholder="Enter harga jual" readonly>
                                                                </div>
                                                            </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <br>
                                                            <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" onclick="removerow(` +
                    i +
                    `)"> romove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                `);
                mask();
                select_change();
            })
        })

        function removerow(i) {
            $('#row' + i + '').remove();
        }

        function mask() {
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
                    if (result.status == false) {
                        alert("error insert");
                        return false;
                    } else {
                        call_toast(result);
                        setTimeout(function() {
                            window.location.href = "{{ route('produksi.index') }}";
                        }, 1000);

                    }
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

        function mask_number() {
            $('input[id^="harga"]').mask('000.000.000', {
                reverse: true
            });

            $("#bidang").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#pemakaian").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#panjang_bahan").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

        }

        $('#bahan').change(function() {
            var val = $(this).val();
            var bahan = <?php echo json_encode($bahan); ?>;
            for (var i = 0; i < bahan.length; i++) {
                if (parseInt(val) == parseInt(bahan[i].id)) {
                    $('#panjang').val(bahan[i].panjang)
                    $('#sisa_bahan').val(bahan[i].sisa_bahan)
                    break;
                }
            }
        })

        function toasts(result) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            if (result) {
                return Toast.fire({
                    icon: "success",
                    title: "successfully",
                });
            } else {
                return Toast.fire({
                    icon: "error",
                    title: "successfully",
                });
            }
        }

        function clone(param) {
            console.log(param);
            var value = $('#jumlah_produksi' + param).val()
            $('#sisa_jumlah_produksi' + param).val(value)
        }

        function select_change() {
            $('.size').change(function() {
                var value = $(this).val();
                var attr = $(this).attr("id")
                $(".size").not(this).each(function() {
                    if ($(this).val() == value) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ukuran tidak boleh sama..!!',
                        })
                        $('#' + attr).val('');
                        return false;
                    }
                });

            })
        }
    </script>
@endsection
