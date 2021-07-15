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
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    Product</button>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>kode</th>
                                        <th>Name</th>
                                        <th>Harga Modal</th>
                                        <th>Stock</th>
                                        <th>status</th>
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
    @include('product.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $("#harga_modal").mask('000.000.000', {reverse: true});

            $("#stock").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('product.index') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'harga_modal',
                        name: 'harga_modal',
                        render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ' )
                    },
                    {
                        data: 'stock',
                        name: 'stock'
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
                    url: "product/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $("#id").val(result.id)
                        $('#kode').val(result.kode);
                        $('#name').val(result.name);
                        $('#harga_modal').val(result.harga_modal);
                        $('#stock').val(result.stock);
                        $("#status").val(result.status ).change();
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

        function add_edit() {

            var id = $('#id').val();
            var kode = $('#kode').val();
            var name = $('#name').val();
            var harga_modal = $('#harga_modal').val();
            var stock = $('#stock').val();
            var status = $('#status').val();

            var object = {
                kode,
                name,
                harga_modal,
                status
            }

            if (required_fild(object) == false) {
                return false;
            }

            var dataInput = {
                kode,
                name,
                harga_modal,
                stock,
                status
            }

            $.ajax({
                url: "{{ route('product.store') }}",
                type: "post",
                data: {
                    "id": id,
                    "data": dataInput,
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
        }

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
                        url: "product/" + id,
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

        function active(id, active) {
            if (id == null) {
                console.log('error bosq.')
                return false
            }
            $.ajax({
                url: {!! json_encode(url('product/active')) !!},
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
