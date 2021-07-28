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
                            <label for="parent">Parent <a class="tn">*</a></label>
                            <select class="form-control inputForm" id="parent" data-placeholder="Select a parent"
                                style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="name" name="name"
                                aria-describedby="emailHelp" placeholder="Enter name" required>
                        </div>
                        <div class="form-group" id="ctrl">
                            <label for="controller">Controller <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="controller" name="controller"
                                aria-describedby="emailHelp" placeholder="Enter controller">
                        </div>
                        <div class="form-group">
                            <label for="order">Order NO <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="order" name="order"
                                aria-describedby="emailHelp" placeholder="Enter order" required>
                        </div>
                        <div class="form-group">
                            <label for="status">status <a class="tn">*</a></label>
                            <select class="form-control" id="status" required>
                                <option value="1">Active</option>
                                <option value="0">not Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
