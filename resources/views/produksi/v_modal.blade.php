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
                    {{-- <input type="hidden" class="form-control inputForm" id="forms" name="forms" value=""> --}}
                    <div class="col-md-12">
                        <div class="form-group add">
                            <label for="bahan">Bahan <a class="tn">*</a></label>
                            <select class="form-control select2" id="bahan" data-placeholder="Select a bahan"
                                data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                <option value="" disabled selected>Choose .. </option>
                                @foreach ($bahan as $val)
                                    <option value="{{ $val->id }}">{{ $val->kode }} - {{ $val->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group add">
                            <label for="product">Product <a class="tn">*</a></label>
                            <select class="form-control select2" id="product" data-placeholder="Select a product"
                                data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                <option value="" disabled selected>Choose .. </option>
                                @foreach ($product as $val)
                                    <option value="{{ $val->id }}">{{ $val->kode }} - {{ $val->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="jumlah" name="jumlah"
                                aria-describedby="emailHelp" placeholder="Enter jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="sisa">Sisa <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="sisa" name="sisa"
                                aria-describedby="emailHelp" placeholder="Enter sisa">
                            <small id="emailHelp" class="form-text text-muted">jika sisa di kosongkan value akan
                                mengikuti jumlah.</small>
                        </div>
                        <div class="form-group">
                            <label for="status">status <a class="tn">*</a></label>
                            <select class="form-control status" id="status" required>
                                <option value="1">Active</option>
                                <option value="0">not Active</option>
                            </select>
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
