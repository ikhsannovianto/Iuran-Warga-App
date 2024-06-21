<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaransTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pembayarans')->insert([
            [
                'id_warga' => 1,
                'jumlah_dibayar' => 100000,
                'tanggal_bayar' => '2024-01-15',
                'metode_pembayaran' => 'Tunai',
                'bulan' => 1, // Tambahkan nilai untuk kolom bulan
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_warga' => 2,
                'jumlah_dibayar' => 200000,
                'tanggal_bayar' => '2024-02-20',
                'metode_pembayaran' => 'Transfer',
                'bulan' => 2, // Tambahkan nilai untuk kolom bulan
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
