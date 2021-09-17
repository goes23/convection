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
                            <label for="name">Name <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="name" name="name"
                                 placeholder="Enter name" required>
                        </div>
                         <div class="form-group">
                            <label for="email">Email <a class="tn">*</a></label>
                            <input type="email" class="form-control inputForm" id="email" name="email"
                                 placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <a class="tn">*</a></label>
                            <input type="password" class="form-control inputForm" id="password" name="password"
                                 placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="repassword">Repassword <a class="tn">*</a></label>
                            <input type="password" class="form-control inputForm" id="repassword" name="repassword"
                                 placeholder="Enter repassword">
                        </div>
                        <div class="form-group">
                            <label for="role">Role <a class="tn">*</a></label>
                            <select class="form-control select2" id="role" data-placeholder="Select a role"
                                data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                @foreach ($role as $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
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
