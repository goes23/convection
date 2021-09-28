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
                            <label for="name">Name hutang <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="name" name="name"
                                placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_hutang">Jumlah hutang <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="jumlah_hutang" name="jumlah_hutang"
                                placeholder="Enter jumlah hutang" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_hutang">Tanggal hutang <a class="tn">*</a></label>
                            <input type="date" class="form-control inputForm" id="tanggal_hutang" name="tanggal_hutang"
                                placeholder="Enter tanggal hutang" required>
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
