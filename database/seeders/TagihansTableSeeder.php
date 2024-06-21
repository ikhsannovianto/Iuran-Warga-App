<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagihansTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tagihans')->insert([
            [
                'id_warga' => 1,
                'bulan' => 1,
                'tahun' => 2024,
                'jumlah_tagihan' => 100000,
                'status' => 'belum dibayar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_warga' => 2,
                'bulan' => 2,
                'tahun' => 2024,
                'jumlah_tagihan' => 200000,
                'status' => 'belum dibayar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
