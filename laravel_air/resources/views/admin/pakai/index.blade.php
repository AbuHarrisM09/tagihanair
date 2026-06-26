@extends('layouts.app')

@section('title', 'Data Pemakaian')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Data Pemakaian Air</h2>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.pakai.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Tambah Pemakaian
        </a>
        <br><br>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Daftar Pemakaian
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-pakai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pemakaian</th>
                                <th>Pelanggan</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Awal</th>
                                <th>Akhir</th>
                                <th>Pakai</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pakai as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->id_pakai }}</td>
                                <td>{{ $p->pelanggan->nama_pelanggan ?? '-' }}</td>
                                <td>{{ $p->bulan->nama_bulan ?? '-' }}</td>
                                <td>{{ $p->tahun }}</td>
                                <td>{{ number_format($p->awal) }}</td>
                                <td>{{ number_format($p->akhir) }}</td>
                                <td>{{ number_format($p->pakai) }}</td>
                                <td>Rp {{ number_format($p->tagihan->tagihan ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <span class="label label-{{ $p->tagihan->status == 'Lunas' ? 'success' : 'warning' }}">
                                        {{ $p->tagihan->status ?? 'Belum Ada Tagihan' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.pakai.destroy', $p) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
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
        $('#dataTables-pakai').DataTable({
            "responsive": true,
            "order": [[0, "desc"]]
        });
    });
</script>
@endpush
