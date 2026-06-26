<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_pelanggan', 'nama_pelanggan', 'alamat', 'no_hp', 'status', 'id_layanan'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }

    public function pemakaian()
    {
        return $this->hasMany(Pakai::class, 'id_pelanggan');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'no_rek', 'id_pelanggan');
    }
}
