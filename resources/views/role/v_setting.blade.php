<style>
    #accordion {
        overflow: auto;
        max-height: 600px;
        padding: 5px;
    }

</style>
<div class="modal fade" id="modal-setting">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add">
                <div class="modal-header">
                    <h4 class="modal-title">Setting Access</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control inputForm" id="id" name="id" value="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="select_role">Role <a class="tn">*</a></label>
                            <select class="form-control" id="select_role" data-placeholder="Select a role"
                                style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkall" type="checkbox" id="checkall" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">check all</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select_role">Permission</label>
                            <div id="accordion">
                               <div id="access_module"></div>
                            </div>
                            <div class="access_permission"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_role_access()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
