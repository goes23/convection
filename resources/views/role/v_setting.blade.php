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
                            <label for="name">Name Role<a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="name" name="name"
                                aria-describedby="emailHelp" placeholder="Enter name role">
                        </div>
                         <div class="form-group">
                            <label for="description">Description <a class="tn">*</a></label>
                            <textarea class="form-control inputForm" id="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">status <a class="tn">*</a></label>
                            <select class="form-control status" id="status">
                                <option value="1">Active</option>
                                <option value="0">not Active</option>
                            </select>
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
