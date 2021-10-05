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
{{ $tbody->links() }}
<div class="modal-footer">
    <a href="report/create" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
</div>
