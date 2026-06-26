<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pakai;
use App\Models\Pelanggan;
use App\Models\Bulan;
use App\Models\Layanan;
use App\Models\Tagihan;

class PakaiController extends Controller
{
    public function index()
    {
        $pakai = Pakai::with(['pelanggan', 'bulan', 'tagihan'])->latest()->get();
        return view('admin.pakai.index', compact('pakai'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::where('status', 'Aktif')->orderBy('id_pelanggan')->get();
        $bulan = Bulan::orderBy('id_bulan')->get();
        $layanan = Layanan::first();
        
        return view('admin.pakai.create', compact('pelanggan', 'bulan', 'layanan'));
    }

    public function getMeteranAwal($idPelanggan)
    {
        $pakaiTerakhir = Pakai::where('id_pelanggan', $idPelanggan)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        return response()->json([
            'awal' => $pakaiTerakhir ? $pakaiTerakhir->akhir : 0
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pakai' => 'required|string|max:11|unique:tb_pakai,id_pakai',
            'id_pelanggan' => 'required|string|exists:tb_pelanggan,id_pelanggan',
            'bulan' => 'required|string|size:3|exists:tb_bulan,id_bulan',
            'tahun' => 'required|string|size:4',
            'awal' => 'required|numeric',
            'akhir' => 'required|numeric|gt:awal',
        ]);

        $total = $validated['akhir'] - $validated['awal'];
        
        // Get tarif from layanan
        $pelanggan = Pelanggan::find($validated['id_pelanggan']);
        $layanan = Layanan::find($pelanggan->id_layanan);
        $harga = $total * $layanan->tarif;

        \DB::transaction(function () use ($validated, $total, $harga) {
            // Insert to tb_pakai
            Pakai::create([
                'id_pakai' => $validated['id_pakai'],
                'id_pelanggan' => $validated['id_pelanggan'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
                'awal' => $validated['awal'],
                'akhir' => $validated['akhir'],
                'pakai' => $total,
            ]);

            // Insert to tb_tagihan
            Tagihan::create([
                'id_pakai' => $validated['id_pakai'],
                'tagihan' => $harga,
                'status' => 'Belum Bayar',
            ]);
        });

        return redirect()->route('admin.pakai.index')->with('success', 'Data pemakaian berhasil disimpan.');
    }

    public function destroy(Pakai $pakai)
    {
        try {
            $pakai->delete();
            return redirect()->route('admin.pakai.index')->with('success', 'Data pemakaian berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pakai.index')->with('error', 'Gagal menghapus data pemakaian.');
        }
    }

    public function generateCode()
    {
        $lastCode = Pakai::orderBy('id_pakai', 'desc')->first();
        
        if (!$lastCode) {
            $newCode = 'K000000001';
        } else {
            $lastNumber = (int) substr($lastCode->id_pakai, 1);
            $newNumber = $lastNumber + 1;
            $newCode = 'K' . str_pad($newNumber, 8, '0', STR_PAD_LEFT);
        }

        return response()->json(['code' => $newCode]);
    }
}
