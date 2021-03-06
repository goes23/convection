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
                                <?php if (allowed_access(session('user'), 'pengeluaran', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    Pengeluaran</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Pengeluaran</th>
                                        <th>Jumlah Pengeluaran</th>
                                        <th>Tanggal Pengeluaran</th>
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
    @include('pengeluaran.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {

            $('#jumlah_pengeluaran').mask('000.000.000', {
                reverse: true
            });

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengeluaran.index') }}",
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
                        data: 'jumlah_pengeluaran',
                        name: 'jumlah_pengeluaran',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'tanggal_pengeluaran',
                        name: 'tanggal_pengeluaran',
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
                    url: "pengeluaran/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        var currentDate = new Date(result.tanggal_pengeluaran);
                        var year = currentDate.getFullYear();
                        var month = currentDate.getMonth() + 1 < 10 ? "0" + (parseInt(currentDate.getMonth()) +
                                1) : currentDate
                            .getMonth() + 1;
                        var date = currentDate.getDate() < 10 ? "0" + currentDate.getDate() : currentDate
                            .getDate();
                        var date_format = year + "-" + month + "-" + date
                        $("#id").val(result.id)
                        $('#name').val(result.name);
                        $("#jumlah_pengeluaran").val(result.jumlah_pengeluaran);
                        $("#tanggal_pengeluaran").val(date_format);
                        $('#modal-default').modal('show');
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
                url: "{{ route('pengeluaran.store') }}",
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
                        url: "pengeluaran/" + id,
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
    </script>
@endsection
