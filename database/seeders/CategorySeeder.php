<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Buku Pelajaran SMP', 'icon' => '📖', 'urutan' => 1],
            ['name' => 'Buku Pelajaran SD',  'icon' => '📚', 'urutan' => 2],
            ['name' => 'Buku Pelajaran SMA', 'icon' => '📕', 'urutan' => 3],
            ['name' => 'Modul & LKS',        'icon' => '📓', 'urutan' => 4],
            ['name' => 'Buku Agama',         'icon' => '🕌', 'urutan' => 5],
            ['name' => 'Buku TKA',           'icon' => '✏️', 'urutan' => 6],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                $cat
            );
        }
    }
}
