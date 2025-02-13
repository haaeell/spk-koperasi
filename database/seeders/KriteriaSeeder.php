<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kriteria::insert([
            ['nama' => 'Organisasi', 'bobot' => 0.3, 'jenis' => 'benefit'],
            ['nama' => 'Tata Letak dan Manajemen', 'bobot' => 0.25, 'jenis' => 'benefit'],
            ['nama' => 'Produktifitas', 'bobot' => 0.2, 'jenis' => 'benefit'],
            ['nama' => 'Manfaat dan Dampak', 'bobot' => 0.15, 'jenis' => 'benefit'],
            ['nama' => 'Pengembangan dan Daya Saing', 'bobot' => 0.1, 'jenis' => 'cost'],
        ]);
    }
}
