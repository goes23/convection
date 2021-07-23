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
                                <?php if (allowed_access(session('user'), 'module', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah Module</button>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Parent</th>
                                        <th>Name</th>
                                        <th>Controller</th>
                                        <th>Order No</th>
                                        <th>status</th>
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
    @include('module.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $("#order").inputmask('Regex', {
                regex: "^[0-9]{1,12}(\\.\\d{1,2})?$"
            });

            var parent = $('#parent').val()

            if (parent == null || parent == 0) {

                $('#ctrl').hide()
            } else {

                $('#ctrl').show()
            }

            $('#parent').change(function() {
                var parent = $('#parent').val()
                if (parent == 0) {
                    $('#ctrl').hide()
                } else {
                    $('#ctrl').show()
                }
            })

            data_parent();

            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('module.index') }}",
                    type: "GET"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'parent_id',
                        name: 'parent_id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'controller',
                        name: 'controller',
                    },
                    {
                        data: 'order_no',
                        name: 'order_no'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        rderable: false,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                columnDefs: [{
                    "width": "20px",
                    "targets": 0
                }]
            });
        })

        function data_parent() {
            $.ajax({
                url: "{{ route('module.dataparent') }}",
                type: "post",
                data: 0,
                dataType: "json",
                success: function(result) {
                    $("#parent > option").remove();

                    var option = '';
                    option += '<option value="0" > #Parent </option>'
                    for (var i = 0; i < result.length; i++) {
                        option += '<option value="' + result[i].id + '">' + result[i].name + '</option>'
                    }
                    $('#parent').append(option);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        }

        function edit(id) {
            if (id) {
                $.ajax({
                    url: "module/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        $("#id").val(result.id)
                        $("#parent").val(result.parent_id).change();
                        $("#name").val(result.name)
                        $('#controller').val(result.controller);
                        $('#order').val(result.order_no);
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
            var parent = $('#parent').val();
            var name = $('#name').val();
            var controller = $('#controller').val();
            var order = $('#order').val();
            var status = $('#status').val();

            if (parent == 0) {
                var object = {
                    parent,
                    name,
                    order,
                    status
                }
            } else {
                var object = {
                    parent,
                    name,
                    controller,
                    order,
                    status
                }
            }

            if (required_fild(object) == false) {
                return false;
            }

            $.ajax({
                url: "{{ route('module.store') }}",
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
                        $('#modal-default').modal('hide');
                    }, 1500);
                    data_parent();
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
                        url: "module/" + id,
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
                url: {!! json_encode(url('module/active')) !!},
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

        function functionUp(param) {
            var rowValue = param.value;
            var vl = $("#order-" + rowValue).html();

            if (vl <= 1) {
                return false;
            } else {
                var order = parseInt(vl) - 1;
                $("#order-" + rowValue).html(order);
                $.ajax({
                    url: {!! json_encode(url('module/updatenorder')) !!},
                    type: "POST",
                    data: {
                        id: rowValue,
                        order_no: order,
                    },
                    success: function(result) {
                        $("#example1").DataTable().ajax.reload();
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    },
                })
            }
        }

        function functionDown(param) {

            var rowValue = param.value;
            var vl = $("#order-" + rowValue).html();
            var order = parseInt(vl) + 1;
            $("#order-" + rowValue).html(order);

            $.ajax({
                url: {!! json_encode(url('module/updatenorder')) !!},
                type: "POST",
                data: {
                    id: rowValue,
                    order_no: order,
                },
                success: function(result) {
                    $("#example1").DataTable().ajax.reload();
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                },
            })
        }

    </script>
@endsection
