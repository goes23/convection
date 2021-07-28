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
                                <?php if (allowed_access(session('user'), 'role', 'add')): ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="add_btn()">Tambah
                                    role</button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-warning btn-sm" onclick="setting_access()">Setting
                                    access</button>
                                <button type="button" class="btn btn-success btn-sm" onclick="custom_access()">Custom
                                    access</button>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
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
    @include('role.v_modal')
    {{-- MODAL FORM ADD & EDIT --}}
    {{-- MODAL FORM ADD & EDIT --}}
    @include('role.v_setting')
    {{-- MODAL FORM ADD & EDIT --}}
    {{-- MODAL FORM ADD & EDIT --}}
    @include('role.v_custom')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.inputForm').val('');
            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('role.index') }}",
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
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                    url: "role/" + id + "/edit",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $("#id").val(result.id)
                        $('#name').val(result.name);
                        $('#description').val(result.description);
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
            var name = $('#name').val();
            var description = $('#description').val();
            var status = $('#status').val();

            var object = {
                name,
                status
            }

            if (required_fild(object) == false) {
                return false;
            }

            var object2 = {
                name,
                description,
                status
            }

            $.ajax({
                url: "{{ route('role.store') }}",
                type: "post",
                data: {
                    "id": id,
                    "data": object2,
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
                        url: "role/" + id,
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
                url: {!! json_encode(url('role/active')) !!},
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

        function setting_access() {
            $('#access_module').html('');
            $('#checkall').prop("checked", false);
            $.ajax({
                url: {!! json_encode(url('role/datarole')) !!},
                type: "POST",
                data: 1,
                dataType: "json",
                success: function(result) {
                    $("#select_role > option").remove();

                    var option = '';
                    option += '<option value="" disabled selected>Select your option</option>'
                    for (var i = 0; i < result.length; i++) {
                        option += '<option value="' + result[i].id + '">' + result[i].name + '</option>'
                    }
                    $('#select_role').append(option);
                    $('#modal-setting').modal('show');
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        }

        $('#select_role').change(function() {
            var selected = $('#select_role').val()
            if (selected != "") {
                $('#checkall').prop("checked", false);
                $('#access_module').html('')
                $.ajax({
                    url: {!! json_encode(url('role/get_access')) !!},
                    type: "POST",
                    data: {
                        selected: selected
                    },
                    dataType: "json",
                    success: function(result) {
                        var headercollapseOne = '';
                        for (var i = 0; i < result.module_access.length; i++) {
                            var bodycollapseOne = '';
                            for (var j = 0; j < result.module_access[i].access.length; j++) {
                                var checked = '';
                                for (const key in result.role_access) {
                                    if (result.module_access[i].access[j].id == result.role_access[key]
                                        .access_id) {
                                        checked = 'checked="checked"';
                                    }
                                }
                                bodycollapseOne +=
                                    `<div class="form-check form-check-inline">
                                                                    <input name="checkbox" class="form-check-input checkboxs" type="checkbox" id="check` +
                                    result.module_access[i].access[j].id + `
                                                                    " ` + checked + ` value="` + result.module_access[i]
                                    .access[j]
                                    .id + `">
                                                                    <label class="form-check-label" for="check` + result
                                    .module_access[i].access[j].id + `">` +
                                    result.module_access[i].access[j].permission +
                                    `</label>
                                                                </div>`;
                            }
                            headercollapseOne += `<div class="card ">
                                                                    <div class="card-header" style="padding: 2px 0px 3px 13px;">
                                                                        <h4 class="card-title w-100">
                                                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                                                                ` + result.module_access[i].name + `
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                                        <div class="card-body" style="padding: 3px 0px 3px 40px;">
                                                                            <div class="panel-body">
                                                                            ` + bodycollapseOne + `
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                               </div>`;

                        }

                        $('#access_module').html(headercollapseOne)
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });

            } else {
                $('#access_module').html('')
            }
        })

        $('#checkall').click(function() {
            if (this.checked) {
                $('.checkboxs').prop("checked", true);
            } else {
                $('.checkboxs').prop("checked", false);
            }
        })


        function custom_access() {
            $('#modal-custom').modal('show');
        }


        function add_role_access() {
            var selected = $('#select_role').val();
            var checkboxs = $('.checkboxs').serializeArray()
            if (selected != null) {
                $.ajax({
                    url: {!! json_encode(url('role/add_role_access')) !!},
                    type: "POST",
                    data: {
                        "role_id": selected,
                        "access_id": checkboxs
                    },
                    dataType: "json",
                    success: function(result) {
                        call_toast(result)
                        setTimeout(function() {
                        $('#modal-setting').modal('hide');
                    }, 1500);
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            } else {
                return false;
            }
        }

        $('#add_permission').submit(function(e) {
            e.preventDefault();
            var module_id = $('#module_id').val();
            var permission = $('#permission').val();
            var object = {
                module_id,
                permission
            }

            if (required_fild(object) == false) {
                return false;
            }

            $.ajax({
                url: {!! json_encode(url('role/add_permission')) !!},
                type: "POST",
                data: {
                    "module_id": module_id,
                    "permission": permission
                },
                dataType: "json",
                success: function(result) {
                    call_toast(result)
                    setTimeout(function() {
                        $('#modal-custom').modal('hide');
                    }, 1500);
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })

    </script>
@endsection
