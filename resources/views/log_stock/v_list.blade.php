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
                                <?php if (allowed_access(session('user'), 'log_stock', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    Log Stock</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Transfer Date</th>
                                        <th>action</th>
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
    @include('log_stock.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $(".inputForm").val('');

            $("#qty").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('log_stock.index') }}",
                    type: "GET"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'transfer_date',
                        name: 'transfer_date',
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

        $('#product').change(function() {
            var id = $('#product').val();
            if (id == "") {
                $('#sisa').val(0);
            } else {
                $.ajax({
                    url: "log_stock/" + id + "/get_sisa",
                    type: "get",
                    dataType: "json",
                    success: function(result) {
                        $('#sisa').val(result[0].sisa);
                        $('#produksi_id').val(result[0].id);
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            }

        })

        function edit(id) {
            if (id) {
                $.ajax({
                    url: "log_stock/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        var currentDate = new Date(result.transfer_date);
                        var year = currentDate.getFullYear();
                        var month = currentDate.getMonth() + 1 < 10 ? "0" + (parseInt(currentDate.getMonth()) +
                                1) : currentDate
                            .getMonth() + 1;
                        var date = currentDate.getDate() < 10 ? "0" + currentDate.getDate() : currentDate
                            .getDate();
                        var date_format = year + "-" + month + "-" + date
                        console.log(result);
                        $("#id").val(result.id)
                        $('#qty').val(result.qty);
                        $('#transfer_date').val(date_format);
                        $('#product').val(result.product_id).change();
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
            var sisa = $('#sisa').val();
            var product = $('#product').val();
            var produksi = $('#produksi_id').val();
            var qty = $('#qty').val();
            var transfer_date = $('#transfer_date').val();

            if (parseInt(sisa) < parseInt(qty)) {
                Swal.fire({
                    icon: "error",
                    text: "quantity melebihi sisa!!",
                });
                return false;
            }

            var object = {
                product,
                qty,
                transfer_date
            }

            if (required_fild(object) == false) {
                return false;
            }

        
            $.ajax({
                url: "{{ route('log_stock.store') }}",
                type: "post",
                data: {
                    "id": id,
                    "produksi_id" :produksi,
                    "data": object,
                },
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
                        url: "log_stock/" + id,
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
