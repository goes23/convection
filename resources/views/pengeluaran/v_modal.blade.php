<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name Pengeluaran <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="name" name="name"
                                placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_pengeluaran">Jumlah Pengeluaran <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="jumlah_pengeluaran" name="jumlah_pengeluaran"
                                placeholder="Enter jumlah pengeluaran" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pengeluaran">Tanggal Pengeluaran <a class="tn">*</a></label>
                            <input type="date" class="form-control inputForm" id="tanggal_pengeluaran" name="tanggal_pengeluaran"
                                placeholder="Enter tanggal pengeluaran" required>
                        </div>
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
