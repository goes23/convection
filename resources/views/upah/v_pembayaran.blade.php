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
                    <input type="hidden" class="form-control byr" id="id_upah" name="id" value="">
                    <input type="hidden" class="form-control byr" id="total_upah" name="total_upah" value="">
                    <div class="form-group">
                        <label for="sisa_upah">Sisa Upah <a class="tn">*</a></label>
                        <input type="text" class="form-control byr" id="sisa_upah" name="sisa_upah"
                            aria-describedby="emailHelp" readonly>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_pembayaran">Jumlah Pembayaran <a class="tn">*</a></label>
                        <input type="text" class="form-control byr" id="jumlah_pembayaran"
                            name="jumlah_pembayaran" aria-describedby="emailHelp" placeholder="Enter jumlah pembayaran"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="tgl_pembayaran">Tanggal Pembayaran<a class="tn">*</a></label>
                        <input type="date" class="form-control byr" id="tgl_pembayaran" name="tgl_pembayaran"
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
