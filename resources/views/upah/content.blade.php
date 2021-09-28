@extends('product.v_modal_history')
<h5 class="text-center">History Stock</h5>
<table class="table table-striped" id="history-table" width="100%">
    <thead id="tblHead">
        <tr>
            <th>Nomor</th>
            <th>Jumlah Pembayaran</th>
            <th>Keterangan</th>
            <th>Tanggal Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        @foreach ($history as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->jumlah_pembayaran }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->tanggal_pembayaran }}</td>
            </tr>

        @endforeach
    </tbody>
</table>
{{ $history->links() }}
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">close</button>
</div>

<script>
    $(document).on('ajaxComplete ajaxReady ready', function() {
        $('ul.pagination li a').off('click').on('click', function(e) {
            e.preventDefault()
            var href = $(this).attr("href")
            $.ajax({
                url: href,
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#modals').html(result.html);
                    $('#modal-history').modal('show');
                },
                error: function(xhr, Status, err) {
                    $("Terjadi error : " + Status);
                }
            });
        })
    })
</script>
