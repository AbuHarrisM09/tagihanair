<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class PelangganTagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get pelanggan ID from user's no_rek
        $tagihan = Tagihan::whereHas('pakai', function($query) use ($user) {
            $query->where('id_pelanggan', $user->no_rek);
        })
        ->with(['pakai.pelanggan', 'pembayaran'])
        ->latest()
        ->get();

        return view('pelanggan.tagihan.index', compact('tagihan'));
    }

    public function lunas()
    {
        $user = Auth::user();
        
        $tagihan = Tagihan::whereHas('pakai', function($query) use ($user) {
            $query->where('id_pelanggan', $user->no_rek);
        })
        ->where('status', 'Lunas')
        ->with(['pakai.pelanggan', 'pembayaran'])
        ->latest()
        ->get();

        return view('pelanggan.tagihan.lunas', compact('tagihan'));
    }
}
