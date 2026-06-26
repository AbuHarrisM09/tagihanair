<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';

    protected $fillable = ['nama_user', 'username', 'password', 'level', 'no_hp', 'no_rek'];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'no_rek', 'id_pelanggan');
    }

    public function isAdmin()
    {
        return $this->level === 'Administrator';
    }

    public function isPelanggan()
    {
        return $this->level === 'Pelanggan';
    }
}
