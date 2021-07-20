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
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div style=" padding: 0px 0px 18px 0px;">
                                <?php if (allowed_access(session('user'), 'bahan', 'add')): ?>
                                        <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah Bahan</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>kode</th>
                                        <th>Name</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Harga</th>
                                        <th>Panjang</th>
                                        <th>Satuan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

    {{-- MODAL FORM ADD & EDIT --}}
    @include('bahan.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $("#harga").mask('000.000.000', {
                reverse: true
            });
            $("#panjang").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('bahan.index') }}",
                    type: "GET"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'buy_at',
                        name: 'buy_at'
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'panjang',
                        name: 'panjang'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'asc']
                ]
            });
        })

        function edit(id) {
            if (id) {
                $.ajax({
                    url: "bahan/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        var currentDate = new Date(result.buy_at);
                        var year = currentDate.getFullYear();
                        var month = currentDate.getMonth() + 1 < 10 ? "0" + (parseInt(currentDate.getMonth()) +
                                1) : currentDate
                            .getMonth() + 1;
                        var date = currentDate.getDate();
                        var date_format = year + "-" + month + "-" + date

                        $("#id").val(result.id)
                        $('#kode').val(result.kode);
                        $('#name').val(result.name);
                        $('#tgl').val(date_format);
                        $('#harga').val(result.harga);
                        $('#panjang').val(result.panjang);
                        $('#satuan').val(result.satuan);
                        $("#status").val(result.status).change();
                        $('#modal-xl').modal('show');
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            } else {
                return false
            }
        }

        $('#form_add_edit').submit(function(e){
            e.preventDefault();

            var id = $('#id').val();
            var kode = $('#kode').val();
            var name = $('#name').val();
            var buy_at = $('#tgl').val();
            var harga = $('#harga').val();
            var panjang = $('#panjang').val();
            var satuan = $('#satuan').val();
            var status = $('#status').val();

            var object = {
                kode,
                name,
                buy_at,
                harga,
                panjang,
                satuan,
                status,
            }

            if (required_fild(object) == false) {
                return false;
            }

            $.ajax({
                url: "{{ route('bahan.store') }}",
                type: "post",
                data: {
                    "id": id,
                    "data": object,
                },
                dataType: "json",
                success: function(result) {
                    call_toast(result)
                    $(".inputForm").val('');
                    $("#example1").DataTable().ajax.reload()
                    setTimeout(function() {
                        $('#modal-xl').modal('hide');
                    }, 1500);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

        function my_delete(id = null) {
            if (id == null) {
                return false
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "bahan/" + id,
                        type: "delete",
                        dataType: "json",
                        success: function(result) {
                            console.log(result);
                            status_delete(result)
                            $("#example1").DataTable().ajax.reload()
                        },
                        error: function(xhr, Status, err) {
                            $("Terjadi error : " + Status);
                        }
                    });
                }
            })
        }

        function add_btn() {
            var id = $('#id').val();
            if (id != "") {
                $(".inputForm").val('');
            }
            $('#modal-xl').modal('show');
        }

        function active(id, active) {
            if (id == null) {
                console.log('error bosq.')
                return false
            }
            $.ajax({
                url: {!! json_encode(url('bahan/active')) !!},
                type: "POST",
                data: {
                    "id": id,
                    "data": active,
                },
                dataType: "json",
                success: function(result) {
                    call_toast(result)
                    $("#example1").DataTable().ajax.reload()
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        }

    </script>
@endsection
