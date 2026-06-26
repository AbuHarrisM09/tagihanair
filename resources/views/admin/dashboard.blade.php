@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard</h2>
        <hr/>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-primary text-center no-boder bg-color-blue">
            <div class="panel-body">
                <i class="fa fa-users fa-5x"></i>
                <h3>{{ \App\Models\Pelanggan::count() }}</h3> Total Pelanggan
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-success text-center no-boder bg-color-green">
            <div class="panel-body">
                <i class="fa fa-tint fa-5x"></i>
                <h3>{{ \App\Models\Pakai::count() }}</h3> Data Pemakaian
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="panel panel-warning text-center no-boder bg-color-yellow">
            <div class="panel-body">
                <i class="fa fa-file-text fa-5x"></i>
                <h3>{{ \App\Models\Tagihan::where('status', 'Belum Bayar')->count() }}</h3> Belum Lunas
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="panel panel-danger text-center no-boder bg-color-red">
            <div class="panel-body">
                <i class="fa fa-check-circle fa-5x"></i>
                <h3>{{ \App\Models\Tagihan::where('status', 'Lunas')->count() }}</h3> Sudah Lunas
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Selamat Datang, {{ auth()->user()->nama_user }}
            </div>
            <div class="panel-body">
                <p>Sistem Informasi Tagihan Air Minum</p>
                <p>Level Akses: <strong>{{ auth()->user()->level }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
