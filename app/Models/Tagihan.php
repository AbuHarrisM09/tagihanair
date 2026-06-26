<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tb_tagihan';
    protected $primaryKey = 'id_tagihan';

    protected $fillable = ['id_pakai', 'tagihan', 'status'];

    public function pakai()
    {
        return $this->belongsTo(Pakai::class, 'id_pakai');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_tagihan');
    }
}
