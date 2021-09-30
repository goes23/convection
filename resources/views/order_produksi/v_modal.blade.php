<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="bayar" id="bayar">
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
                        <label for="sisa_pembayaran">Sisa Pembayaran <a class="tn">*</a></label>
                        <input type="text" class="form-control byr" id="sisa_pembayaran" name="sisa_pembayaran"
                            aria-describedby="emailHelp" readonly>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_pembayaran">Jumlah Pembayaran <a class="tn">*</a></label>
                        <input type="text" class="form-control byr" id="jumlah_pembayaran" name="jumlah_pembayaran"
                            aria-describedby="emailHelp" placeholder="Enter jumlah pembayaran" required>
                    </div>

                    <div class="form-group">
                        <label for="tgl_pembayaran">Tanggal Pembayaran<a class="tn">*</a></label>
                        <input type="date" class="form-control byr" id="tgl_pembayaran" name="tgl_pembayaran"
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
