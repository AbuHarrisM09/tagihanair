<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'tb_pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = ['id_tagihan', 'tgl_bayar', 'uang_bayar', 'kembali'];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan');
    }
}
