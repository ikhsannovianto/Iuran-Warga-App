<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WargasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('wargas')->insert([
            [
                'nama' => 'Warga 1',
                'alamat' => 'Alamat Warga 1',
                'no_telp' => '081234567890',
                'email' => 'warga1@example.com',
                'id_rt' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Warga 2',
                'alamat' => 'Alamat Warga 2',
                'no_telp' => '081234567891',
                'email' => 'warga2@example.com',
                'id_rt' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
