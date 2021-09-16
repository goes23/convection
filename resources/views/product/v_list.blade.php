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
                                <?php if (allowed_access(session('user'), 'product', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    Product</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>kode</th>
                                        <th>Name</th>
                                        <th>Foto</th>
                                        <th>Harga Jual</th>
                                        <th>Harga Modal Product</th>
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
            $('.inputForm').val('');
            $("#harga_modal").mask('000.000.000', {
                reverse: true
            });

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
                        data: 'img',
                        name: 'img',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual'
                    },
                    {
                        data: 'harga_modal_product',
                        name: 'harga_modal_product',
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
                    url: "product/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $("#id").val(result.id)
                        $('#kode').val(result.kode);
                        $('#name').val(result.name);
                        $('#harga_jual').val(result.harga_jual);
                        $("#harga_modal_product").val(result.harga_modal_product);
                        $('.edit').show();
                        if (result.foto != null) {
                            $('#output').attr('src', "{{ asset('assets/img/') }}/" + result.foto);
                        }else{
                            $('#output').attr('src', "");
                        }
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
            var kode = $('#kode').val();
            var name = $('#name').val();

            var object = {
                kode,
                name
            }

            if (required_fild(object) == false) {
                return false;
            }

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
            $('.edit').hide();
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

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };

    </script>
@endsection
