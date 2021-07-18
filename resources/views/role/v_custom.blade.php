<div class="modal fade" id="modal-custom">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_add">
                <div class="modal-header">
                    <h4 class="modal-title">Custom Access</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="module_id">Module <a class="tn">*</a></label>
                        <select class="form-control" id="module_id" data-placeholder="Select a module"
                            style="width: 100%;">
                            @foreach ($module as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permission">Name Permission<a class="tn">*</a></label>
                        <input type="text" class="form-control inputForm" id="permission" name="permission"
                            aria-describedby="emailHelp" placeholder="Enter permission">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_permission()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
