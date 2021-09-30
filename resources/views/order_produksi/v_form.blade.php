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

                <form name="order_produksi" id="order_produksi">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" id="id" name="id"
                                    value="{{ isset($data[0]->id) ? (int) $data[0]->id : '' }}">
                                <div class="form-group">
                                    <label for="name">Nama <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="name" name="name"
                                        placeholder="Enter nama" value="{{ isset($data[0]->name) ? $data[0]->name : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_modal_satuan">Harga Modal Satuan <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control harga" id="harga_modal_satuan"
                                        name="harga_modal_satuan" placeholder="Enter harga modal satuan"
                                        value="{{ isset($data[0]->harga_modal_satuan) ? (int) $data[0]->harga_modal_satuan : '' }}"
                                        required>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga_jual_satuan">Harga Jual Satuan <a class="tn">*</a></label>
                                    <input type="text" class="form-control harga" id="harga_jual_satuan"
                                        name="harga_jual_satuan" placeholder="Enter harga jual satuan"
                                        value="{{ isset($data[0]->harga_jual_satuan) ? (int) $data[0]->harga_jual_satuan : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="qty" name="qty"
                                        placeholder="Enter quantity"
                                        value="{{ isset($data[0]->qty) ? (int) $data[0]->qty : '' }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_pembayaran">Total Pembayaran <a class="tn">*</a></label>
                                    <input type="text" class="form-control harga" id="total_pembayaran"
                                        name="total_pembayaran" placeholder="Enter total pembayaran"
                                        value="{{ isset($data[0]->total_pembayaran) ? (int) $data[0]->total_pembayaran : '' }}"
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
    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {

            $(".harga").mask('000.000.000', {
                reverse: true
            });

            $('input[id^="qty"]').inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
        })



        $('#order_produksi').submit(function(e) {
            e.preventDefault();
            var dataForm = new FormData(this);
            $.ajax({
                url: "{{ route('order_produksi.store') }}",
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
                            window.location.href =
                                "{{ route('order_produksi.index') }}";
                        }, 1000);

                    }
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })
    </script>
@endsection
