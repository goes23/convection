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
                            <label for="product">Product <a class="tn">*</a></label>
                            <select class="form-control inputForm" id="product" required>
                                <option value="">Select Product</option>
                                @foreach ($produksi as $item)
                                <option value="{{$item->product_id}}">{{$item->name}}</option>
                                @endforeach
                                <input type="hidden" class="form-control inputForm" id="produksi_id" name="produksi_id" value="">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sisa">Sisa Produksi <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="sisa" name="sisa"
                                 placeholder="0" readonly>
                        </div>
                        <div class="form-group">
                            <label for="qty">Qty <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="qty" name="qty"
                                 placeholder="Enter quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="transfer_date">Transfer Date <a class="tn">*</a></label>
                            <input type="date" class="form-control inputForm" id="transfer_date" name="transfer_date"
                                required>
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
