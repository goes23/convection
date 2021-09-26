<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <form name="form_add_edit" id="form_add_edit">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $modal_title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control inputForm" id="id" name="id" value="">
                    <div class="form-group">
                        <label for="kode_produksi">Kode Produksi <a class="tn">*</a></label>
                        <select class="form-control" id="kode_produksi" name="kode_produksi" required>
                            <option value="">choose..</option>
                            @foreach ($produksi as $item)
                                <option value="{{ $item->id }}">{{ $item->kode_produksi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_upah">Total Upah <a class="tn">*</a></label>
                        <input type="text" class="form-control inputForm" id="total_upah" name="total_upah"
                            aria-describedby="emailHelp" placeholder="Enter total upah" required>
                    </div>
                    <div class="form-group">
                        <label for="sisa_upah">Sisa Upah <a class="tn">*</a></label>
                        <input type="text" class="form-control inputForm" id="sisa_upah" name="sisa_upah"
                            aria-describedby="emailHelp" placeholder="Enter sisa upah" required>
                    </div>
                    <div class="form-group">
                        <label for="date_transaksi">Tanggal transaksi<a class="tn">*</a></label>
                        <input type="date" class="form-control inputForm" id="date_transaksi" name="date_transaksi"
                            aria-describedby="emailHelp" placeholder="Enter jumlah" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
