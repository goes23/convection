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

    {{-- MODAL FORM ADD & EDIT --}}
    @include('product.v_modal_stock')
    {{-- MODAL FORM ADD & EDIT --}}

    {{-- MODAL FORM ADD & EDIT --}}
    @include('product.v_modal_history')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.inputForm').val('');
            mask_number();

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
                        name: 'harga_jual',
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
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
                        } else {
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


        function stock(id) {
            $('#id').val(id)
            $('#kode_produksi').val('');
            $('#size').val('');
            $('#jumlah_produksi').val('')
            $('#sisa_jumlah_produksi').val('')
            $.ajax({
                url: "product/" + id + "/produksi",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result.length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Product belum di prosess di produksi',
                        })
                        return false;
                    }
                    var opt = '';
                    opt += '<option value="" disabled selected>Choose ..</option>';
                    for (var i = 0; i < result.length; i++) {
                        opt += '<option value="' + result[i].id + '">' + result[i].id +
                            '</option>'
                    }
                    $('#kode_produksi').html(opt)
                    $('#modal-stock').modal('show');
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        }

        $('#kode_produksi').change(function() {
            var id = $('#kode_produksi').val();
            $.ajax({
                url: "product/" + id + "/variants",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    //console.log(result);dd()
                    var opt = '';
                    opt += '<option value="" disabled selected>Choose ..</option>';
                    for (var i = 0; i < result.length; i++) {
                        opt += '<option value="' + result[i].id + '">' + result[i].size +
                            '</option>'
                    }
                    $('#size').html(opt)
                    $('#modal-stock').modal('show');

                    $('#size').change(function() {
                        for (const key in result) {
                            if (parseInt($(this).val()) == result[key].id) {
                                $('#variant_id').val(result[key]
                                    .id)
                                $('#jumlah_produksi').val(result[key]
                                    .jumlah_produksi)
                                $('#sisa_jumlah_produksi').val(result[key].sisa_jumlah_produksi)
                                $('#jumlah_stock_product').val(result[key].jumlah_stock_product)
                                break;
                            }
                        }
                    })
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };

        function mask_number() {
            $('input[id^="harga"]').mask('000.000.000', {
                reverse: true
            });
            $("#jumlah_stock_product").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            $("#input_jumlah_product").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });


        }

        $('#form_stock').submit(function(e) {
            e.preventDefault();
            var btn = $(this).find("input[type=submit]:focus");
            var tombol = btn[0].value;
            var product_id = $('#id').val()
            var variant_id = $('#variant_id').val()
            var kode_produksi = $('#kode_produksi').val()
            var size = $('#size').val()
            var jumlah_produksi = $('#jumlah_produksi').val()
            var sisa_jumlah_produksi = $('#sisa_jumlah_produksi').val()
            var jumlah_stock_product = $('#jumlah_stock_product').val()
            var input_jumlah_product = $('#input_jumlah_product').val()
            var transfer_date = $('#transfer_date').val()
            var keterangan = $('#keterangan').val()

            if (input_jumlah_product == 0) {
                alert("Input jumlah product tidak boleh 0");
                return false;
            }

            input = {
                tombol,
                product_id,
                variant_id,
                kode_produksi,
                size,
                jumlah_produksi,
                sisa_jumlah_produksi,
                jumlah_stock_product,
                input_jumlah_product,
                transfer_date,
                keterangan
            }


            $.ajax({
                url: "{{ route('product.log_stock') }}",
                type: "POST",
                data: {
                    data: input
                },
                dataType: "json",
                success: function(result) {
                    if (result.status == false) {
                        alert(result.msg);
                        return false
                    } else {
                        call_toast(result)
                        $(".inputForm").val('');
                        $("#example1").DataTable().ajax.reload()
                        setTimeout(function() {
                            $('#modal-stock').modal('hide');
                        }, 1500);
                    }
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

        function history(id) {
            $.ajax({
                url: "product/" + id + "/history",
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
