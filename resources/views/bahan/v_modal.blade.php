<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form name="form_add_edit" id="form_add_edit">
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
                                             placeholder="Enter kode" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl">Tanggal Pembelian <a class="tn">*</a></label>
                                        <input type="date" class="form-control inputForm" id="tgl" name="tgl_pembelian"
                                             placeholder="Enter tangggal pembelian"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="name" name="name"
                                             placeholder="Enter name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="harga" name="harga"
                                             placeholder="Enter harga" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panjang">panjang <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="panjang" name="panjang"
                                             placeholder="Enter panjang" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="satuan">Satuan <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="satuan" name="satuan"
                                             placeholder="Enter satuan" required>
                                    </div>
                                </div>

                                <div class="col-md-4" id ="sisa_hide">
                                    <div class="form-group">
                                        <label for="sisa_bahan">Sisa bahan <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="sisa_bahan" name="sisa_bahan"
                                             placeholder="Enter sisa bahan" disabled>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="harga_satuan">Harga Satuan <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="harga_satuan" name="harga_satuan"
                                             placeholder="Enter satuan" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="discount">Discount <a class="tn">*</a></label>
                                        <input type="text" class="form-control inputForm" id="discount" name="discount"
                                             placeholder="Enter satuan" required>
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
                    <button type="submit" class="btn btn-primary" >Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


