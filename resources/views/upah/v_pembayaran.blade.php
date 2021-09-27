<div class="modal fade" id="modal-pembayaran">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <form name="pembayaran" id="pembayaran">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $modal_title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control inputForm" id="id_upah" name="id" value="">

                    <div class="form-group">
                        <label for="jumlah_pembayaran">Jumlah pembayaran <a class="tn">*</a></label>
                        <input type="text" class="form-control inputForm" id="jumlah_pembayaran" name="jumlah_pembayaran"
                            aria-describedby="emailHelp" placeholder="Enter jumlah pembayaran" required>
                    </div>

                    <div class="form-group">
                        <label for="tgl_pembayaran">Tanggal pembayaran<a class="tn">*</a></label>
                        <input type="date" class="form-control inputForm" id="tgl_pembayaran" name="tgl_pembayaran"
                            aria-describedby="emailHelp" placeholder="Enter jumlah" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-warning" name='data' value="pembayaran" />
                    <input type="submit" class="btn btn-success" name='data' value="revisi" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
