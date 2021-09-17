<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="form_add_edit" id="form_add_edit" enctype="multipart/form-data">
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
                            <label for="kode">Kode <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="kode" name="kode"
                                 placeholder="Enter kode" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name <a class="tn">*</a></label>
                            <input type="text" class="form-control inputForm" id="name" name="name"
                                 placeholder="Enter name" required>
                        </div>

                        <div class="form-group edit">
                            <label for="foto">Foto </label>
                            <img class="inputForm" id="output"/ style="padding: 0px;margin-bottom: 21px;margin-left: 9px;" width="250" height="250">
                            <input type="file"  class="form-control inputForm" accept="image/*" onchange="loadFile(event)" name="file">
                            {{-- <input type="text" class="form-control inputForm" id="foto" name="foto"
                                 placeholder="Enter foto" > --}}
                        </div>
                        <div class="form-group edit">
                            <label for="harga_jual">Harga Jual </label>
                            <input type="text" class="form-control inputForm" id="harga_jual" name="harga_jual"
                                 placeholder="Enter harga jual" >
                        </div>

                        <div class="form-group edit">
                            <label for="harga_modal_product">Harga Modal Product </label>
                            <input type="text" class="form-control inputForm" id="harga_modal_product" name="harga_modal_product"
                                 placeholder="Enter harga modal product" >
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
