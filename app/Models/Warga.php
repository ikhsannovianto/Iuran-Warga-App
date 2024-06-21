<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'no_telp', 'email', 'id_rt'];

    public function rt()
    {
        return $this->belongsTo(RT::class, 'id_rt');
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_warga');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_warga');
    }
}
