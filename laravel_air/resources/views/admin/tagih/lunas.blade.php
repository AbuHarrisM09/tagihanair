@extends('layouts.app')

@section('title', 'Tagihan Lunas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Data Tagihan Lunas</h2>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Riwayat Tagihan Yang Sudah Dibayar
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-lunas">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Tagihan</th>
                                <th>Pelanggan</th>
                                <th>Bulan/Tahun</th>
                                <th>Pemakaian</th>
                                <th>Tagihan</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah Bayar</th>
                                <th>Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $index => $t)
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
                                    {{ $t->pembayaran->tgl_bayar ?? '-' }}
                                </td>
                                <td>
                                    Rp {{ number_format($t->pembayaran->uang_bayar ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($t->pembayaran->kembali ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="label label-success">{{ $t->status }}</span>
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
        $('#dataTables-lunas').DataTable({
            "responsive": true,
            "order": [[0, "desc"]]
        });
    });
</script>
@endpush
