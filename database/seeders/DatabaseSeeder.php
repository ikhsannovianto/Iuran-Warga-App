<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RtsTableSeeder::class,
            LingkungansTableSeeder::class,
            WargasTableSeeder::class,
            TagihansTableSeeder::class,
            PembayaransTableSeeder::class,
        ]);
    }
}
