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
                                <?php if (allowed_access(session('user'), 'upah', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah Upah</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>kode Produksi</th>
                                        <th>Total Upah</th>
                                        <th>Sisa Upah</th>
                                        <th>Tanggal Transaksi</th>
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
    @include('upah.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}

    {{-- MODAL FORM ADD & EDIT --}}
    @include('upah.v_pembayaran')
    {{-- MODAL FORM ADD & EDIT --}}
    {{-- MODAL FORM ADD & EDIT --}}
    @include('upah.v_modal_history')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.inputForm').val('');

            mask_number() // mendaftarkan mask

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('upah.index') }}",
                    type: "GET"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'produksi_id',
                        name: 'produksi_id'
                    },
                    {
                        data: 'total_upah',
                        name: 'total_upah',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'sisa_upah',
                        name: 'sisa_upah',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'date_transaksi',
                        name: 'date_transaksi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    "width": "20px",
                    "targets": 0
                }]
            });
        })

        function edit(id) {
            if (id) {
                $.ajax({
                    url: "upah/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        // console.log(result);
                        // return
                        var currentDate = new Date(result.data.date_transaksi);
                        var year = currentDate.getFullYear();
                        var month = currentDate.getMonth() + 1 < 10 ? "0" + (parseInt(currentDate.getMonth()) +
                                1) : currentDate
                            .getMonth() + 1;
                        var date = currentDate.getDate() < 10 ? "0" + currentDate.getDate() : currentDate
                            .getDate();
                        var date_format = year + "-" + month + "-" + date
                        $("#id").val(result.id)
                        if (result.history == true) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Upah tidak bisa di edit karna sudah ada pembayaran',
                            })
                            return false;
                        } else {
                            $('#kode_produksi').val(result.data.produksi_id).change();
                            $('#total_upah').val(result.data.total_upah);
                            $('#sisa_upah').val(result.data.sisa_upah);
                            $('#date_transaksi').val(date_format);
                            $('#modal-xl').modal('show');
                        }
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            } else {
                return false
            }
        }

        $('#form_add_edit').submit(function(e) {
            e.preventDefault();
            var dataForm = new FormData(this);
            $.ajax({
                url: "{{ route('upah.store') }}",
                type: "post",
                data: dataForm,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(result) {
                    if (result.status == false) {

                    } else {
                        call_toast(result);
                        setTimeout(function() {
                            window.location.href = "{{ route('upah.index') }}";
                        }, 1000);

                    }
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
                        url: "upah/" + id,
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
            $('#kode_produksi').val('').change();
            var id = $('#id').val();
            if (id != "") {
                $(".inputForm").val('');
            }

            // $('#sisa_hide').hide();
            $('#modal-xl').modal('show');
        }

        function active(id, active) {
            if (id == null) {
                console.log('error bosq.')
                return false
            }
            $.ajax({
                url: {!! json_encode(url('upah/active')) !!},
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


        function mask_number() {
            $('#sisa_upah').mask('000.000.000', {
                reverse: true
            });
            $('#total_upah').mask('000.000.000', {
                reverse: true
            });

            $('#jumlah_pembayaran').mask('000.000.000', {
                reverse: true
            });

        }

        function bayar(id) {
            // console.log('oke');
            // return;
            $('.byr').val('')
            $.ajax({
                url: "upah/" + id + "/edit",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $("#id_upah").val(result.data.id)
                    $('#total_upah').val(result.data.total_upah);
                    $('#sisa_upah').val(result.data.sisa_upah);
                    $('#modal-pembayaran').modal('show');
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });

        }

        $('#pembayaran').submit(function(e) {
            e.preventDefault();

            var btn = $(this).find("input[type=submit]:focus");
            var tombol = btn[0].value;
            var id_upah = $('#id_upah').val();
            var total_upah = $('#total_upah').val();
            var sisa_upah = $('#sisa_upah').val()
            var jumlah_pembayaran = $('#jumlah_pembayaran').val()
            var tanggal_pembayaran = $('#tgl_pembayaran').val()


            var object = {
                tombol,
                id_upah,
                total_upah,
                sisa_upah,
                jumlah_pembayaran,
                tanggal_pembayaran
            }

            $.ajax({
                url: "{{ route('upah.bayar') }}",
                type: "post",
                data: object,
                dataType: "json",
                success: function(result) {
                    if (result.status == false) {
                        alert(result.msg);
                        return false;
                    }
                    call_toast(result)
                    $("#example1").DataTable().ajax.reload()
                    setTimeout(function() {
                        $('#modal-pembayaran').modal('hide');
                    }, 1500);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

        function history(id) {
            $.ajax({
                url: "upah/" + id + "/history",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#modals').html(result.html);
                    $('#modal-history').modal('show');
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        }
    </script>
@endsection
