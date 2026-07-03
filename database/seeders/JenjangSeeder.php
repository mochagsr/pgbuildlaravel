<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    public function run(): void
    {
        $jenjangs = [
            ['nama' => 'SD',   'urutan' => 1],
            ['nama' => 'SMP',  'urutan' => 2],
            ['nama' => 'SMA',  'urutan' => 3],
            ['nama' => 'SMK',  'urutan' => 4],
            ['nama' => 'Umum', 'urutan' => 5],
        ];

        foreach ($jenjangs as $j) {
            Jenjang::firstOrCreate(['nama' => $j['nama']], $j);
        }
    }
}
