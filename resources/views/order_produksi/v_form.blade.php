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

                                <div class="form-group">
                                    <label for="name">Nama <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="name" name="name"
                                        placeholder="Enter nama"
                                        value="{{ isset($data_produksi[0]->name) ? (int) $data_produksi[0]->name : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_modal_satuan">Harga Modal Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_modal_satuan"
                                        name="harga_modal_satuan" placeholder="Enter harga modal satuan"
                                        value="{{ isset($data_produksi[0]->harga_modal_satuan) ? (int) $data_produksi[0]->harga_modal_satuan : '' }}"
                                        required>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga_jual_satuan">Harga Jual Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_jual_satuan"
                                        name="harga_jual_satuan" placeholder="Enter harga jual satuan"
                                        value="{{ isset($data_produksi[0]->harga_jual_satuan) ? (int) $data_produksi[0]->harga_jual_satuan : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="qty" name="qty"
                                        placeholder="Enter quantity"
                                        value="{{ isset($data_produksi[0]->qty) ? (int) $data_produksi[0]->qty : '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_pembayaran">Total Pembayaran <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="total_pembayaran"
                                        name="total_pembayaran" placeholder="Enter total pembayaran"
                                        value="{{ isset($data_produksi[0]->total_pembayaran) ? (int) $data_produksi[0]->total_pembayaran : '' }}"
                                        required>
                                </div>

                            </div>
                        </div>
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
    {{-- <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            mask_number();
            var status = {{ $status }}
            $('#status').val(status)
            if (status != 1) {
                $('#product').val('');
                $('#bahan').val('');
                $('#size').val('').change();
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
                                                            <select class="form-control inputForm" id="size" name="variants[` +
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
    </script> --}}
@endsection
