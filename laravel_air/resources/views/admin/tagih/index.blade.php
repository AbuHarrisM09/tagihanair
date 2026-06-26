@extends('layouts.app')

@section('title', 'Data Tagihan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Data Tagihan Air</h2>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tagihan Belum Lunas
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-tagihan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Tagihan</th>
                                <th>Pelanggan</th>
                                <th>Bulan/Tahun</th>
                                <th>Pemakaian</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $index => $t)
                            @if($t->status == 'Belum Bayar')
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $t->id_tagihan }}</td>
                                <td>{{ $t->pakai->pelanggan->nama_pelanggan ?? '-' }}</td>
                                <td>
                                    {{ $t->pakai->bulan->nama_bulan ?? '-' }}/{{ $t->pakai->tahun }}
                                </td>
                                <td>{{ number_format($t->pakai->pakai ?? 0) }} m³</td>
                                <td>Rp {{ number_format($t->tagihan, 0, ',', '.') }}</td>
                                <td>
                                    <span class="label label-warning">{{ $t->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.tagihan.bayar', $t) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-money"></i> Bayar
                                    </a>
                                    <form action="{{ route('admin.tagihan.destroy', $t) }}" method="POST" 
                                          style="display:inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus tagihan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTables-tagihan').DataTable({
            "responsive": true,
            "order": [[0, "desc"]]
        });
    });
</script>
@endpush
