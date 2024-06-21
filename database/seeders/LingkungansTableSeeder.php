<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LingkungansTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('lingkungans')->insert([
            [
                'nama_lingkungan' => 'Lingkungan A',
                'alamat' => 'Alamat Lingkungan A',
                'ketua_lingkungan' => 'Ketua A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lingkungan' => 'Lingkungan B',
                'alamat' => 'Alamat Lingkungan B',
                'ketua_lingkungan' => 'Ketua B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
