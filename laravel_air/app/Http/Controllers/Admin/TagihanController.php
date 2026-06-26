<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['pakai.pelanggan', 'pembayaran'])->latest()->get();
        return view('admin.tagihan.index', compact('tagihan'));
    }

    public function bayar(Tagihan $tagihan)
    {
        return view('admin.tagihan.bayar', compact('tagihan'));
    }

    public function prosesBayar(Request $request, Tagihan $tagihan)
    {
        $validated = $request->validate([
            'uang_bayar' => 'required|numeric|min:' . $tagihan->tagihan,
        ]);

        $kembali = $validated['uang_bayar'] - $tagihan->tagihan;

        Pembayaran::create([
            'id_tagihan' => $tagihan->id_tagihan,
            'tgl_bayar' => Carbon::now(),
            'uang_bayar' => $validated['uang_bayar'],
            'kembali' => $kembali,
        ]);

        $tagihan->update(['status' => 'Lunas']);

        return redirect()->route('admin.tagihan.index')->with('success', 'Pembayaran berhasil diproses.');
    }

    public function lunas()
    {
        $tagihan = Tagihan::where('status', 'Lunas')
            ->with(['pakai.pelanggan', 'pembayaran'])
            ->latest()
            ->get();
        
        return view('admin.tagihan.lunas', compact('tagihan'));
    }

    public function destroy(Tagihan $tagihan)
    {
        try {
            $tagihan->delete();
            return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.tagihan.index')->with('error', 'Gagal menghapus tagihan.');
        }
    }
}
