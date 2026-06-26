@extends('layouts.app')

@section('title', 'Bayar Tagihan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Bayar Tagihan</h2>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading">
                Form Pembayaran
            </div>
            <div class="panel-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="alert alert-info">
                    <strong>Pelanggan:</strong> {{ $tagihan->pakai->pelanggan->nama_pelanggan ?? '-' }}<br>
                    <strong>Bulan/Tahun:</strong> 
                        {{ $tagihan->pakai->bulan->nama_bulan ?? '-' }}/{{ $tagihan->pakai->tahun }}<br>
                    <strong>Pemakaian:</strong> {{ number_format($tagihan->pakai->pakai ?? 0) }} m³<br>
                    <strong>Total Tagihan:</strong> Rp {{ number_format($tagihan->tagihan, 0, ',', '.') }}
                </div>

                <form method="POST" action="{{ route('admin.tagihan.prosesBayar', $tagihan) }}">
                    @csrf
                    <div class="form-group">
                        <label>Jumlah Bayar</label>
                        <input type="number" name="uang_bayar" class="form-control" 
                               min="{{ $tagihan->tagihan }}" required 
                               placeholder="Masukkan jumlah pembayaran"/>
                        <small class="text-muted">Minimal: Rp {{ number_format($tagihan->tagihan, 0, ',', '.') }}</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Proses Pembayaran
                        </button>
                        <a href="{{ route('admin.tagihan.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
