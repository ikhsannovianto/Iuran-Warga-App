<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'id_warga', 'jumlah_dibayar', 'tanggal_bayar', 'metode_pembayaran', 'bulan'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}

