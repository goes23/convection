<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_add">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $modal_title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $card_title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <input type="hidden" class="form-control inputForm" id="id" name="id" value="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode">Kode <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="kode" name="kode"
                                            aria-describedby="emailHelp" placeholder="Enter kode">
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl">Tanggal Pembelian <a class="tn">*</a></label>
                                        <input type="date" class="form-control inputForm" id="tgl" name="tgl_pembelian"
                                            aria-describedby="emailHelp" placeholder="Enter tangggal pembelian"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="name" name="name"
                                            aria-describedby="emailHelp" placeholder="Enter name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="harga" name="harga"
                                            aria-describedby="emailHelp" placeholder="Enter harga" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panjang">panjang <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="panjang" name="panjang"
                                            aria-describedby="emailHelp" placeholder="Enter panjang" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="satuan">Satuan <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="satuan" name="satuan"
                                            aria-describedby="emailHelp" placeholder="Enter satuan" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">status <a class="tn">*</a></label>
                                        <select class="form-control" id="status">
                                            <option value="1">Active</option>
                                            <option value="0">not Active</option>
                                          </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add_input_form"></div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_edit()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
