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
                                <?php if (allowed_access(session('user'), 'order_produksi', 'add')): ?>
                                <Form method="post" action="{{ route('order_produksi.form') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Tambah order produksi</button>
                                </Form>
                                <?php endif; ?>

                                <?php /* if (allowed_access(session('user'), 'order_produksi', 'add')): ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    order_produksi</button>
                                <?php endif; */?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>

                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Harga Modal Satuan</th>
                                        <th>Harga Jual Satuan</th>
                                        <th>Qty</th>
                                        <th>Total Pembayaran</th>
                                        <th>Sisa Pembayaran</th>
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
    @include('order_produksi.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.inputForm').val('');
            $('#bahan').select2({
                dropdownParent: $('#modal-default')
            });
            $('#product').select2({
                dropdownParent: $('#modal-default')
            });

            $("#jumlah").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });
            $("#sisa").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('order_produksi.index') }}",
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
                        data: 'harga_modal_satuan',
                        name: 'harga_modal_satuan',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'harga_jual_satuan',
                        name: 'harga_jual_satuan',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'total_pembayaran',
                        name: 'total_pembayaran',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                    },
                    {
                        data: 'sisa_pembayaran',
                        name: 'sisa_pembayaran',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
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
                    url: "order_produksi/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $('.add').hide();
                        $('#id').val(result.id)
                        // $("#forms").val('edit');
                        $('#bahan').val(result.bahan_id).change();
                        $('#product').val(result.product_id).change();
                        $('#jumlah').val(result.jumlah);
                        $('#sisa').val(result.sisa);
                        $("#status").val(result.status).change();
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
            var id = $('#id').val();
            var bahan = $('#bahan').val();
            var product = $('#product').val();
            var jumlah = $('#jumlah').val();
            var status = $('#status').val();
            var sisa = $('#sisa').val();

            if (sisa != "") {
                if (parseInt(sisa) > parseInt(jumlah)) {
                    Swal.fire({
                        icon: "error",
                        text: "sisa melebihi jumlah !!",
                    });
                    return false;
                }
            }

            var object = {
                bahan,
                product,
                jumlah,
                status
            }

            if (required_fild(object) == false) {
                return false;
            }

            $.ajax({
                url: "{{ route('order_produksi.store') }}",
                type: "post",
                data: {
                    "id": id,
                    "sisa": sisa,
                    "data": object
                },
                dataType: "json",
                beforeSend: function() {
                    console.log("ok")
                },
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

        function my_delete(id) {
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
                        url: "order_produksi/" + id,
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

        function bayars(id) {
            $.ajax({
                url: "order_produksi/" + id + "/get_data",
                type: "get",
                dataType: "json",
                success: function(result) {
                    $('#sisa_pembayaran').val(result.sisa_pembayaran)
                    $('#modal-default').modal('show');
                   // mask();
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });

        }
    </script>
@endsection
