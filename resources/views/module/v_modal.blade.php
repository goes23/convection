<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_add">
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
                            <label for="kode">Parent <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="kode" name="kode"
                                aria-describedby="emailHelp" placeholder="Enter kode">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="kode" name="kode"
                                aria-describedby="emailHelp" placeholder="Enter kode">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order NO <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="kode" name="kode"
                                aria-describedby="emailHelp" placeholder="Enter kode">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_edit()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
