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
                                <?php if (allowed_access(session('user'), 'order_header', 'add')): ?>
                                <Form method="post" action="{{ route('order_header.form') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Tambah Order Header </button>
                                </Form>
                                <?php endif; ?>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Purchase Code</th>
                                        <th>Customer Name</th>
                                        <th>Customer Phone</th>
                                        <th>Customer Address</th>
                                        <th>Channel</th>
                                        <th>Purchase Date</th>
                                        <th>Total Purchase</th>
                                        <th>Shipping Price</th>
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
    @include('order_header.v_modal_detail')
    {{-- MODAL FORM ADD & EDIT --}}


    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $(".inputForm").val('');

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
                    url: "{{ route('order_header.index') }}",
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
                        data: 'purchase_code',
                        name: 'purchase_code'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },
                    {
                        data: 'customer_address',
                        name: 'customer_address',
                    },
                    {
                        data: 'channel.name',
                        name: 'channel.name'
                    },
                    {
                        data: 'purchase_date',
                        name: 'purchase_date',
                    },
                    {
                        data: 'total_purchase',
                        name: 'total_purchase',
                    },
                    {
                        data: 'shipping_price',
                        name: 'shipping_price',
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
                ],
                columnDefs: [{
                    "width": "20px",
                    "targets": 0
                }]
            });
        })

        function detail(id) {
            if (id) {
                $('#detail_order_item').html('');
                $.ajax({
                    url: "order_header/" + id + "/detail",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        var tr = ''
                        var no = 1
                        var total_price = 0;
                        for (var i = 0; i < result.data_detail[0].order_item.length; i++) {
                            total_price += result.data_detail[0].order_item[i].total;
                            tr += `<tr>
                                                    <th scope="row">` + no + `</th>
                                                    <td>` + result.data_detail[0].order_item[i].purchase_code + `</td>
                                                    <td>` + result.data_detail[0].order_item[i].product_id + `</td>
                                                    <td>` + result.data_detail[0].order_item[i].qty + `</td>
                                                    <td class="prices">` + result.data_detail[0].order_item[i].sell_price + `</td>
                                                    <td class="prices">` + result.data_detail[0].order_item[i].total + `</td>
                                                </tr>`
                            no++
                        }

                        $('#purchase_code_detail').html('<b>' + result.data_detail[0].purchase_code + '</b>');
                        $('#detail_cusomer_name').html(result.data_detail[0].customer_name)
                        $('#detail_cusomer_address').html(result.data_detail[0].customer_address)
                        $('#detail_cusomer_phone').html(result.data_detail[0].customer_phone)
                        $('#detail_channel').html(result.data_detail[0].channel.name)
                        $('#detail_purchase_data').html(result.data_detail[0].purchase_date)
                        $('#detail_shipping_purchase').html(result.data_detail[0].shipping_price)
                        $('#detail_order_item').html(` <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">NO</th>
                                                                        <th scope="col">Purchase Code</th>
                                                                        <th scope="col">Product</th>
                                                                        <th scope="col">Qty</th>
                                                                        <th scope="col">Sell Price</th>
                                                                        <th scope="col">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    ` + tr + `
                                                                    <tr>
                                                                        <td colspan="5"><center><b>TOTAL PRICE</b></cebter></td>
                                                                        <td class="prices">` + total_price + `</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>`)
                        mask()
                        $('#modal-xl').modal('show');
                    },
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            } else {
                return false
            }
        }

        function mask() {
            $('.prices').mask('000.000.000', {
                reverse: true
            });
        }

        function form_edit(id) {
            if (id) {
                $.ajax({
                    url: "{{ route('order_header.form') }}",
                    type: "post",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(result) {},
                    error: function(xhr, Status, err) {
                        $("Terjadi error : " + Status);
                    }
                });
            } else {
                return false
            }
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
                        url: "order_header/" + id,
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

        function active(id, active) {
            if (id == null) {
                console.log('error bosq.')
                return false
            }
            $.ajax({
                url: {!! json_encode(url('order_header/active')) !!},
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
