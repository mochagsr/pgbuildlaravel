<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $smp = Category::where('slug', 'buku-pelajaran-smp')->first();
        $sd  = Category::where('slug', 'buku-pelajaran-sd')->first();

        $products = [
            // SMP Kelas 7
            ['judul' => 'Jago Matematika Kelas 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 1],
            ['judul' => 'Genius Islami Kelas 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 2],
            ['judul' => 'Journey to English Mastery 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 3],
            ['judul' => 'Komputasi Kelas 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 4],
            ['judul' => 'Lanskap Ilmu Sosial Kelas 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 5],
            ['judul' => 'Medhar Basa Jawi 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 6],
            ['judul' => 'Menyulam Budaya dalam Prakarya 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 7],
            ['judul' => 'Pancasila Jiwaku Kelas 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 8],
            ['judul' => 'Badan Sehat Mental Kuat 7', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 9],
            ['judul' => 'Modul IPA Kelas 7 Ganjil', 'jenjang' => 'SMP', 'kelas' => '7', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 10],
            // SMP Kelas 8
            ['judul' => 'Jago Matematika Kelas 8', 'jenjang' => 'SMP', 'kelas' => '8', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 11],
            ['judul' => 'Genius Islami Kelas 8', 'jenjang' => 'SMP', 'kelas' => '8', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 12],
            ['judul' => 'Journey to English Mastery 8', 'jenjang' => 'SMP', 'kelas' => '8', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 13],
            ['judul' => 'Komputasi Kelas 8', 'jenjang' => 'SMP', 'kelas' => '8', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 14],
            // SMP Kelas 9
            ['judul' => 'Jago Matematika Kelas 9', 'jenjang' => 'SMP', 'kelas' => '9', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 15],
            ['judul' => 'Genius Islami Kelas 9', 'jenjang' => 'SMP', 'kelas' => '9', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 16],
            ['judul' => 'Journey to English Mastery 9', 'jenjang' => 'SMP', 'kelas' => '9', 'category_id' => $smp?->id, 'tahun' => 2025, 'urutan' => 17],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(['judul' => $p['judul']], array_merge($p, ['is_active' => true]));
        }
    }
}
