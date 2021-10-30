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
                                <?php if (allowed_access(session('user'), 'hutang', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    Hutang</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Hutang</th>
                                        <th>Jumlah Hutang</th>
                                        <th>Sisa</th>
                                        <th>Tanggal Hutang</th>
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
    @include('hutang.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}
    @include('hutang.v_pembayaran')
    @include('hutang.v_modal_history')


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.inputForm').val('');
            $('#jumlah_hutang').mask('000.000.000', {
                reverse: true
            });

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('hutang.index') }}",
                    type: "GET"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'jumlah_hutang',
                        name: 'jumlah_hutang',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'sisa',
                        name: 'sisa',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'tanggal_hutang',
                        name: 'tanggal_hutang',
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
                    url: "hutang/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        var currentDate = new Date(result.data.tanggal_hutang);
                        var year = currentDate.getFullYear();
                        var month = currentDate.getMonth() + 1 < 10 ? "0" + (parseInt(currentDate.getMonth()) +
                                1) : currentDate
                            .getMonth() + 1;
                        var date = currentDate.getDate() < 10 ? "0" + currentDate.getDate() : currentDate
                            .getDate();
                        var date_format = year + "-" + month + "-" + date
                        $("#id").val(result.data.id)

                        if (result.history == true) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Upah tidak bisa di edit karna sudah ada pembayaran',
                            })
                            return false;
                        } else {
                            $('#name').val(result.data.name);
                            $("#jumlah_hutang").val(result.data.jumlah_hutang);
                            $("#tanggal_hutang").val(date_format);
                            $('#modal-default').modal('show');
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

            var dataInput = new FormData(this)

            $.ajax({
                url: "{{ route('hutang.store') }}",
                type: "post",
                data: dataInput,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(result) {
                    call_toast(result)
                    $(".inputForm").val('');
                    $("#example1").DataTable().ajax.reload()
                    setTimeout(function() {
                        $('#modal-default').modal('hide');
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
                        url: "hutang/" + id,
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
            $('#modal-default').modal('show');
        }

        function bayar(id) {

            $('.byr').val('')
            $.ajax({
                url: "hutang/" + id + "/edit",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $("#id_hutang").val(result.data.id)
                    $('#jumlah_hutang').val(result.data.jumlah_hutang);
                    $('#sisa').val(result.data.sisa);
                    $('#modal-pembayaran').modal('show');
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });

        }

        function history(id) {
            $.ajax({
                url: "hutang/" + id + "/history",
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

        $('#pembayaran').submit(function(e) {
            e.preventDefault();

            var btn = $(this).find("input[type=submit]:focus");
            var tombol = btn[0].value;
            var id_hutang = $('#id_hutang').val();
            var jumlah_hutang = $('#jumlah_hutang').val();
            var sisa = $('#sisa').val()
            var jumlah_pembayaran = $('#jumlah_pembayaran').val()
            var tanggal_pembayaran = $('#tgl_pembayaran').val()


            var object = {
                tombol,
                id_hutang,
                jumlah_hutang,
                sisa,
                jumlah_pembayaran,
                tanggal_pembayaran
            }

            $.ajax({
                url: "{{ route('hutang.bayar') }}",
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
    </script>
@endsection
