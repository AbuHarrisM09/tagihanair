@extends('layouts.app')

@section('title', 'Tambah Pemakaian')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Tambah Pemakaian Air</h2>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                Form Tambah Pemakaian
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

                <form method="POST" action="{{ route('admin.pakai.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>ID Pemakaian</label>
                        <input class="form-control" type="text" name="id_pakai" id="id_pakai" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Pelanggan</label>
                        <select name="id_pelanggan" id="id_pelanggan" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id_pelanggan }}">
                                    {{ $p->id_pelanggan }} | {{ $p->nama_pelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="bulan" id="bulan" class="form-control" required>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach($bulan as $b)
                                <option value="{{ $b->id_bulan }}">{{ $b->nama_bulan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="text" name="tahun" class="form-control" placeholder="Masukkan tahun" 
                               value="{{ date('Y') }}" required/>
                    </div>

                    <div class="form-group">
                        <label>Meteran Bulan Lalu</label>
                        <input type="number" name="awal" id="awal" class="form-control" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Meteran Bulan Ini</label>
                        <input type="number" name="akhir" id="akhir" class="form-control" required/>
                    </div>

                    <div class="form-group">
                        <label>Pemakaian (Bulan Ini - Bulan Lalu)</label>
                        <input type="number" name="pakai" id="pakai" class="form-control" readonly/>
                    </div>

                    <input type="hidden" name="tarif" id="tarif" value="{{ $layanan->tarif ?? 0 }}"/>
                    <input type="hidden" name="harga" id="harga"/>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.pakai.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Generate kode otomatis
        $.get("{{ route('admin.pakai.code') }}", function(data) {
            $('#id_pakai').val(data.code);
        });

        // Get meteran awal saat pilih pelanggan
        $('#id_pelanggan').change(function() {
            var idPelanggan = $(this).val();
            if (idPelanggan) {
                $.get("{{ url('admin/pakai/meteran') }}/" + idPelanggan, function(data) {
                    $('#awal').val(data.awal);
                    hitungPemakaian();
                });
            } else {
                $('#awal').val(0);
            }
        });

        // Hitung pemakaian otomatis
        $('#akhir').on('input', function() {
            hitungPemakaian();
        });

        function hitungPemakaian() {
            var awal = parseFloat($('#awal').val()) || 0;
            var akhir = parseFloat($('#akhir').val()) || 0;
            var pakai = akhir - awal;
            $('#pakai').val(pakai);

            var tarif = parseFloat($('#tarif').val()) || 0;
            var harga = pakai * tarif;
            $('#harga').val(harga);
        }
    });
</script>
@endpush
