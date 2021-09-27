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
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ $breadcrumb_item }}</a>
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
                <form name="product_edit" id="product_edit">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ isset($product[0]->id) ? $product[0]->id : '' }}">

                                <div class="form-group">
                                    <label for="kode">kode <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="kode" name="kode"
                                        placeholder="Enter kode"
                                        value="{{ isset($product[0]->kode) ? $product[0]->kode : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="name" name="name"
                                        placeholder="Enter name"
                                        value="{{ isset($product[0]->name) ? $product[0]->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual">Harga jual <a class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_jual" name="harga_jual"
                                        placeholder="Enter harga jual"
                                        value="{{ isset($product[0]->harga_jual) ? $product[0]->harga_jual : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga_modal_product">Harga modal product <a
                                            class="tn">*</a></label>
                                    <input type="text" class="form-control inputForm" id="harga_modal_product"
                                        name="harga_modal_product" placeholder="Enter harga modal"
                                        value="{{ isset($product[0]->harga_modal_product) ? $product[0]->harga_modal_product : '' }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto">foto <a class="tn">*</a></label>
                                    @if ($product[0]->foto != '')
                                        <img class="foto" id="output"
                                            src=" {{ asset('assets/img/') }}/{{ $product[0]->foto }}"
                                            style="padding: 0px;margin-bottom: 21px;margin-left: 9px;" width="250"
                                            height="250">
                                    @else
                                        <img class="foto" id="output"
                                            style="padding: 0px;margin-bottom: 21px;margin-left: 9px;" width="250"
                                            height="250">
                                    @endif
                                    <input type="file" class="form-control foto" accept="image/*" onchange="loadFile(event)"
                                        name="file">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="container-fluid" id="item">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            Info variants
                                        </div>
                                        <div class="card-body">
                                            @foreach ($product as $item)
                                                @foreach ($item->variants as $val)

                                                    <div class="row" id="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="sisa_jumlah_produksi">Produksi <a
                                                                        class="tn">*</a></label>
                                                                <input type="text" class="form-control "
                                                                    id="sisa_jumlah_produksi" placeholder="0"
                                                                    value="{{ $val['id'] }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="sisa_jumlah_produksi">Ukuran <a
                                                                        class="tn">*</a></label>
                                                                <input type="text" class="form-control "
                                                                    id="sisa_jumlah_produksi" placeholder="0"
                                                                    value="{{ $val['size'] }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="sisa_jumlah_produksi">Jumlah produksi <a
                                                                        class="tn">*</a></label>
                                                                <input type="text" class="form-control "
                                                                    id="sisa_jumlah_produksi" placeholder="0"
                                                                    value="{{ $val['jumlah_produksi'] }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="sisa_jumlah_produksi">Sisa jumlah produksi <a
                                                                        class="tn">*</a></label>
                                                                <input type="text" class="form-control "
                                                                    id="sisa_jumlah_produksi" placeholder="0"
                                                                    value="{{ $val['sisa_jumlah_produksi'] }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="sisa_jumlah_produksi">Jumlah stock product <a
                                                                        class="tn">*</a></label>
                                                                <input type="text" class="form-control "
                                                                    id="sisa_jumlah_produksi" placeholder="0"
                                                                    value="{{ $val['jumlah_stock_product'] }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-sm float-right">save change
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.foto').val("");

            $('input[id^="harga"]').mask('000.000.000', {
                reverse: true
            });
        })
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };

        $('#product_edit').submit(function(e) {
            e.preventDefault();
            var dataInput = new FormData(this)

            $.ajax({
                url: "{{ route('product.store') }}",
                type: "POST",
                data: dataInput,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(result) {
                    call_toast(result)

                    setTimeout(function() {
                        window.location.href = "{{ route('product.index') }}";
                    }, 1000);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })
    </script>
@endsection
