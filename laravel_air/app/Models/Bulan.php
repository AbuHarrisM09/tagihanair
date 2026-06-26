<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulan extends Model
{
    use HasFactory;

    protected $table = 'tb_bulan';
    protected $primaryKey = 'id_bulan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_bulan', 'nama_bulan'];

    public function pemakaian()
    {
        return $this->hasMany(Pakai::class, 'bulan', 'id_bulan');
    }
}
