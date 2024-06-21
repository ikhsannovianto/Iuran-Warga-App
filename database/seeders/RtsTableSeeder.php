<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RtsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('rts')->insert([
            [
                'nama_rt' => 1,
                'alamat' => 'Jalan Mawar No. 1',
                'ketua_rt' => 'Bapak A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_rt' => 2,
                'alamat' => 'Jalan Melati No. 2',
                'ketua_rt' => 'Bapak B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
