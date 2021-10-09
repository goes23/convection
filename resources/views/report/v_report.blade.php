@extends('layout.v_template')

<link rel="stylesheet" href="{{ asset('assets/') }}/main.css">
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title_h1 }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ $breadcrumb_item }}</a></li>
                        <li class="breadcrumb-item active">{{ $breadcrumb_item_active }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Report</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('report.export') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="product">Nama module <a class="tn">*</a></label>
                                            <select class="form-control select" onchange="modules(this)" name="module"
                                                style="width: 100%" required>
                                                <option value="" disabled> pilih module </option>
                                                @foreach ($module as $key => $item)
                                                    <option value="{{ $key }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="product">ketegori <a class="tn">*</a></label>
                                            <select class="form-control select" id="kategori" onchange="kategoris(this)"
                                                name="kategori" style="width: 100%" required>
                                                <option value="" disabled> pilih kategori </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="tanggal">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="product">Dari tanggal <a class="tn">*</a></label>
                                            <input type="date" class="form-control inputForm" id="start_date" name="start"
                                                placeholder="Enter purchase date"
                                                value="{{ isset($data_order[0]->purchase_date) ? explode(' ', $data_order[0]->purchase_date)[0] : '' }}"
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="product">Sampai tanggal<a class="tn">*</a></label>
                                            <input type="date" class="form-control inputForm" id="end_date" name="end"
                                                placeholder="Enter purchase date"
                                                value="{{ isset($data_order[0]->purchase_date) ? explode(' ', $data_order[0]->purchase_date)[0] : '' }}"
                                                >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm ">Export excel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.select').val('')
            $('#tanggal').hide()
        })

        function modules(p) {


            if (p.value == 'bahan') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal </option>
                <option value="sisa"> Sisa Bahan Tersedia </option>
                `)
            } else if (p.value == 'product') {
                $('#kategori').html(`
                <option value="all"> Semua Data </option>
                <option value="" disabled> pilih kategori </option>
                <option value="date"> Tanggal </option>

                `)
            } else if (p.value == 'produksi') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal </option>
                `)
            } else if (p.value == 'penjualan') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal </option>
                `)
            } else if (p.value == 'utang') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal </option>
                `)
            } else if (p.value == 'pengeluaran') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal </option>
                `)
            } else if (p.value == 'order_produksi') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal </option>
                <option value="date_pembayaran"> Tanggal Pembayaran </option>
                `)
            } else if (p.value == 'upah') {
                $('#kategori').html(`
                <option value="" disabled> pilih kategori </option>
                <option value="all"> Semua Data </option>
                <option value="date"> Tanggal Transaksi </option>
                <option value="date_pembayaran"> Tanggal Pembayaran </option>
                `)
            }
            $('#kategori').val('')

        }

        function kategoris(param) {
            if (param.value == 'date' || param.value == 'date_pembayaran') {
                $('#tanggal').show()
            } else {
                $('#tanggal').hide()
            }
        }
    </script>

@endsection
