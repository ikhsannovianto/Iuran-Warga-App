<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = ['id_warga', 'bulan', 'tahun', 'jumlah_tagihan', 'tanggal_bayar'];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_warga', 'id_warga');
    }

    public function getStatusAttribute()
    {
        $totalPembayaran = $this->pembayarans->sum('jumlah_dibayar');
        return $totalPembayaran >= $this->jumlah_tagihan ? 'Lunas' : 'Belum Lunas';
    }
}
