<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakai extends Model
{
    use HasFactory;

    protected $table = 'tb_pakai';
    protected $primaryKey = 'id_pakai';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_pakai', 'id_pelanggan', 'bulan', 'tahun', 'awal', 'akhir', 'pakai'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function bulan()
    {
        return $this->belongsTo(Bulan::class, 'bulan', 'id_bulan');
    }

    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_pakai');
    }
}
