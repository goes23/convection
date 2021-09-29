<div class="modal fade" id="modal-stock">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="form_stock" id="form_stock" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control inputForm" id="id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kode_produksi">Kode produksi <a class="tn">*</a></label>
                                <select class="form-control inputForm" id="kode_produksi" name="kode_produksi"
                                    data-placeholder="Select a size" data-dropdown-css-class="select2-purple"
                                    style="width: 100%" required>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="size">Size <a class="tn">*</a></label>
                                <select class="form-control inputForm" id="size" name="size"
                                    data-placeholder="Select a size" data-dropdown-css-class="select2-purple"
                                    style="width: 100%" required>
                                </select>
                                <input type="hidden" class="form-control inputForm" id="variant_id" name="variant_id">
                            </div>
                        </div>
                    </div>
                    {{-- @for ($i = 0; $i < 10; $i++) --}}

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_produksi">Jumlah produksi <a class="tn">*</a></label>
                                <input type="text" class="form-control inputForm" id="jumlah_produksi"
                                    name="jumlah_produksi" placeholder="jumlah produksi" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sisa_jumlah_produksi">Sisa jumlah produksi <a class="tn">*</a></label>
                                <input type="text" class="form-control inputForm" id="sisa_jumlah_produksi"
                                    name="sisa_jumlah_produksi" placeholder="sisa jumlah produksi" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_stock_product">Jumlah stock product tersedia <a class="tn">*</a></label>
                                <input type="text" class="form-control inputForm" id="jumlah_stock_product"
                                    name="jumlah_stock_product" placeholder="0" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_jumlah_product">input jumlah product <a class="tn">*</a></label>
                                <input type="text" class="form-control inputForm" id="input_jumlah_product"
                                    name="input_jumlah_product" placeholder="Enter jumlah product" require>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="transfer_date">Transfer date <a class="tn">*</a></label>
                                <input type="date" class="form-control inputForm" id="transfer_date"
                                    name="transfer_date" placeholder="Enter jumlah stock product" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan <a class="tn">*</a></label>
                                <textarea class="form-control inputForm" id="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- @endfor --}}

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-warning" name='data' value="kurang" />
                    <input type="submit" class="btn btn-success" name='data' value="tambah" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
