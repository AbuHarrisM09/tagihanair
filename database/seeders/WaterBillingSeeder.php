<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaterBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed bulan
        $bulan = [
            ['id_bulan' => 'A', 'nama_bulan' => 'Januari'],
            ['id_bulan' => 'B', 'nama_bulan' => 'Februari'],
            ['id_bulan' => 'C', 'nama_bulan' => 'Maret'],
            ['id_bulan' => 'D', 'nama_bulan' => 'April'],
            ['id_bulan' => 'E', 'nama_bulan' => 'Mei'],
            ['id_bulan' => 'F', 'nama_bulan' => 'Juni'],
            ['id_bulan' => 'G', 'nama_bulan' => 'Juli'],
            ['id_bulan' => 'H', 'nama_bulan' => 'Agustus'],
            ['id_bulan' => 'I', 'nama_bulan' => 'September'],
            ['id_bulan' => 'J', 'nama_bulan' => 'Oktober'],
            ['id_bulan' => 'K', 'nama_bulan' => 'November'],
            ['id_bulan' => 'L', 'nama_bulan' => 'Desember'],
        ];
        DB::table('tb_bulan')->insert($bulan);

        // Seed layanan
        DB::table('tb_layanan')->insert([
            ['id_layanan' => 1, 'layanan' => 'Layanan Air 1', 'tarif' => 1500],
        ]);

        // Seed pelanggan
        $pelanggan = [
            ['id_pelanggan' => 'P001', 'nama_pelanggan' => 'Ahmad', 'alamat' => 'Cimahi', 'no_hp' => '085878526041', 'status' => 'Aktif', 'id_layanan' => 1],
            ['id_pelanggan' => 'P002', 'nama_pelanggan' => 'Budi', 'alamat' => 'Semarang', 'no_hp' => '085878526042', 'status' => 'Aktif', 'id_layanan' => 1],
            ['id_pelanggan' => 'P003', 'nama_pelanggan' => 'Ujang', 'alamat' => 'Cihaurbeuti', 'no_hp' => '123', 'status' => 'Aktif', 'id_layanan' => 1],
            ['id_pelanggan' => 'P004', 'nama_pelanggan' => 'Asep', 'alamat' => 'Sukabumi', 'no_hp' => '087789987654', 'status' => 'Aktif', 'id_layanan' => 1],
        ];
        DB::table('tb_pelanggan')->insert($pelanggan);

        // Seed user (password akan di-hash saat login pertama atau bisa di-set manual)
        // Password default: '1' (sama seperti data lama)
        $users = [
            ['id_user' => 1, 'nama_user' => 'Harris', 'username' => 'admin', 'password' => bcrypt('1'), 'level' => 'Administrator', 'no_hp' => '085878526022', 'no_rek' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_user' => 15, 'nama_user' => 'Ahmad', 'username' => 'ahmad', 'password' => bcrypt('1'), 'level' => 'Pelanggan', 'no_hp' => '085878526041', 'no_rek' => 'P001', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_user' => 16, 'nama_user' => 'Budi', 'username' => 'budi', 'password' => bcrypt('1'), 'level' => 'Pelanggan', 'no_hp' => '085878526042', 'no_rek' => 'P002', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_user' => 20, 'nama_user' => 'Asep', 'username' => 'asep', 'password' => bcrypt('1'), 'level' => 'Pelanggan', 'no_hp' => '087789987654', 'no_rek' => 'P004', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('tb_user')->insert($users);

        // Seed pemakaian
        $pakai = [
            ['id_pakai' => 'K000000001', 'id_pelanggan' => 'P001', 'bulan' => 'A', 'tahun' => '2020', 'awal' => 0, 'akhir' => 10, 'pakai' => 0],
            ['id_pakai' => 'K000000002', 'id_pelanggan' => 'P001', 'bulan' => 'B', 'tahun' => '2020', 'awal' => 10, 'akhir' => 15, 'pakai' => 5],
            ['id_pakai' => 'K000000003', 'id_pelanggan' => 'P001', 'bulan' => 'C', 'tahun' => '2020', 'awal' => 15, 'akhir' => 30, 'pakai' => 15],
            ['id_pakai' => 'K000000004', 'id_pelanggan' => 'P004', 'bulan' => 'A', 'tahun' => '2020', 'awal' => 0, 'akhir' => 0, 'pakai' => 0],
            ['id_pakai' => 'K000000005', 'id_pelanggan' => 'P004', 'bulan' => 'B', 'tahun' => '2020', 'awal' => 0, 'akhir' => 5, 'pakai' => 5],
            ['id_pakai' => 'K000000009', 'id_pelanggan' => 'P001', 'bulan' => 'B', 'tahun' => '2022', 'awal' => 40, 'akhir' => 50, 'pakai' => 10],
            ['id_pakai' => 'K000000010', 'id_pelanggan' => 'P001', 'bulan' => 'C', 'tahun' => '2022', 'awal' => 50, 'akhir' => 60, 'pakai' => 10],
            ['id_pakai' => 'K000000011', 'id_pelanggan' => 'P001', 'bulan' => 'I', 'tahun' => '2022', 'awal' => 60, 'akhir' => 70, 'pakai' => 10],
        ];
        DB::table('tb_pakai')->insert($pakai);

        // Seed tagihan
        $tagihan = [
            ['id_tagihan' => 69, 'id_pakai' => 'K000000002', 'tagihan' => 7500, 'status' => 'Lunas'],
            ['id_tagihan' => 70, 'id_pakai' => 'K000000003', 'tagihan' => 22500, 'status' => 'Lunas'],
            ['id_tagihan' => 72, 'id_pakai' => 'K000000005', 'tagihan' => 7500, 'status' => 'Lunas'],
            ['id_tagihan' => 80, 'id_pakai' => 'K000000010', 'tagihan' => 15000, 'status' => 'Belum Bayar'],
            ['id_tagihan' => 82, 'id_pakai' => 'K000000011', 'tagihan' => 15000, 'status' => 'Lunas'],
        ];
        DB::table('tb_tagihan')->insert($tagihan);

        // Seed pembayaran
        $pembayaran = [
            ['id_tagihan' => 69, 'tgl_bayar' => '2020-06-05', 'uang_bayar' => 10000, 'kembali' => 2500],
            ['id_tagihan' => 72, 'tgl_bayar' => '2020-06-05', 'uang_bayar' => 10000, 'kembali' => 2500],
            ['id_tagihan' => 70, 'tgl_bayar' => '2022-05-22', 'uang_bayar' => 50000, 'kembali' => 27500],
            ['id_tagihan' => 82, 'tgl_bayar' => '2022-05-23', 'uang_bayar' => 20000, 'kembali' => 5000],
        ];
        
        // Update ID untuk pembayaran karena sekarang menggunakan auto-increment
        foreach ($pembayaran as $index => $pembayaranItem) {
            $pembayaran[$index]['id_pembayaran'] = $index + 1;
        }
        
        DB::table('tb_pembayaran')->insert($pembayaran);
    }
}
