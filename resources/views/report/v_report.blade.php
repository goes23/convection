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
                            <h3 class="card-title">Data Report</h3>
                        </div>
                        <div class="card-body">
                            <form id="form_report" name="form_report">
                                <div class="form-group row">
                                    <label for="report" class="col-sm-0 col-form-label">Report</label>
                                    <div class="col-sm-2">
                                        <select class="form-control report" id="report" name="report"
                                            data-placeholder="Select a report" data-dropdown-css-class="select2-purple"
                                            style="width: 100%" required>
                                            <option value="" disabled selected>Choose ..</option>
                                            @foreach ($module as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <label for="date" class="col-sm-0 col-form-label">Date range</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control date" id="inputEmail3" name="start"
                                            placeholder="Email">
                                    </div>
                                    <div class="col-sm-0">
                                        <b>-</b>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control date" id="inputEmail3" name="end"
                                            placeholder="Email">

                                    </div>
                                    <div class="col-sm-2">
                                        <a href="report/create" class="btn btn-success" target="_blank">EXPORT EXCEL</a>
                                    </div>
                                </div>
                            </form>
                            <div id="table"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/') }}/main.js"></script>
    <script>
        $(document).ready(function() {
            $('#report').val('')
            $('.date').val('')
            $('#report').change(function() {
            })
        })
    </script>

@endsection
