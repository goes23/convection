<h5 class="text-center">REPORT</h5>
<table class="table table-striped" id="history-table" width="100%">
    <thead id="tblHead">
        <tr>
            @foreach ($head as $item)
                <th>{{ $item }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        {{-- @if ($table == 'bahan') --}}
            <?php $no = 1; ?>
            @foreach ($tbody as $key => $val)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $val->kode }}</td>
                    <td>{{ $val->name }}</td>
                    <td>{{ $val->harga }}</td>
                    <td>{{ $val->buy_at }}</td>
                    <td>{{ $val->satuan }}</td>
                    <td>{{ $val->panjang }}</td>
                    <td>{{ $val->sisa_bahan }}</td>
                    <td>{{ $val->harga_satuan }}</td>
                    <td>{{ $val->discount }}</td>
                </tr>

            @endforeach
        {{-- @endif --}}
    </tbody>
</table>
{{-- {{ $data->links() }} --}}
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">export</button>
</div>

<script>
    // $(document).on('ajaxComplete ajaxReady ready', function() {
    //     $('ul.pagination li a').off('click').on('click', function(e) {
    //         e.preventDefault()
    //         var href = $(this).attr("href")
    //         $.ajax({
    //             url: href,
    //             type: "GET",
    //             dataType: "json",
    //             success: function(result) {
    //                 $('#modals').html(result.html);
    //                 $('#modal-history').modal('show');
    //             },
    //             error: function(xhr, Status, err) {
    //                 $("Terjadi error : " + Status);
    //             }
    //         });
    //     })
    // })
</script>
