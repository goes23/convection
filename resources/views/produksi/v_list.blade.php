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
                                <?php if (allowed_access(session('user'), 'produksi', 'add')): ?>
                                <Form method="post" action="{{ route('produksi.form') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Tambah produksi</button>
                                </Form>
                                <?php endif; ?>

                                <?php /* if (allowed_access(session('user'), 'produksi', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    produksi</button>
                                <?php endif; */?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Produksi</th>
                                        <th>Product</th>
                                        <th>Bahan</th>
                                        <th>Bidang</th>
                                        <th>Pemakaian</th>
                                        <th>Harga Potong</th>
                                        <th>Harga Jait</th>
                                        <th>Harga Finishing</th>
                                        <th>Harga Aksesoris</th>
                                        <th>Harga Modal Bahan</th>
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
    @include('produksi.v_modal')
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
                    url: "{{ route('produksi.index') }}",
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
                        data: 'kode_produksi',
                        name: 'kode_produksi',
                    },
                    {
                        data: 'product',
                        name: 'product',
                    },
                    {
                        data: 'bahan',
                        name: 'bahan'
                    },
                    {
                        data: 'bidang',
                        name: 'bidang'
                    },
                    {
                        data: 'pemakaian',
                        name: 'pemakaian'
                    },
                    {
                        data: 'harga_potong_satuan',
                        name: 'harga_potong_satuan'
                    },
                    {
                        data: 'harga_jait_satuan',
                        name: 'harga_jait_satuan'
                    },
                    {
                        data: 'harga_finishing_satuan',
                        name: 'harga_finishing_satuan'
                    },
                    {
                        data: 'harga_aksesoris',
                        name: 'harga_aksesoris',
                    },
                    {
                        data: 'harga_modal_bahan_satuan',
                        name: 'harga_modal_bahan_satuan',
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
                    url: "produksi/" + id + "/edit",
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
                url: "{{ route('produksi.store') }}",
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
                        url: "produksi/" + id,
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

        // $('#jumlah').keyup(function() {
        //     var form = $('#forms').val()
        //     console.log(form);
        //     if (form == 'add') {
        //         $('#sisa').val($(this).val());
        //     }
        // });

        function add_btn() {
            var id = $('#id').val();
            if (id != "") {
                $('.add').show();
                // $("#forms").val('add');
                $(".inputForm").val('');
            }
            $('#modal-default').modal('show');
        }

        function active(id, active) {
            if (id == null) {
                console.log('error bosq.')
                return false
            }
            $.ajax({
                url: {!! json_encode(url('produksi/active')) !!},
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
