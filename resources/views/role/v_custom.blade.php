<div class="modal fade" id="modal-custom">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="add_permission" id="add_permission">
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
                            style="width: 100%;" required>
                            @foreach ($module as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permission">Name Permission<a class="tn">*</a></label>
                        <input type="text" class="form-control inputForm" id="permission" name="permission"
                             placeholder="Enter permission" required>
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
