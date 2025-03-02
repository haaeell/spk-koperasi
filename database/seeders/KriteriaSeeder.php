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
            ['nama' => 'Organisasi','kode' => 'A', 'bobot' => 30, 'jenis' => 'benefit'],
            ['nama' => 'Tata Letak dan Manajemen','kode' => 'B', 'bobot' => 25, 'jenis' => 'benefit'],
            ['nama' => 'Produktifitas','kode' => 'C', 'bobot' => 0.2, 'jenis' => 'benefit'],
            ['nama' => 'Manfaat dan Dampak','kode' => 'D', 'bobot' => 15, 'jenis' => 'benefit'],
            ['nama' => 'Pengembangan dan Daya Saing','kode' => 'E', 'bobot' => 10, 'jenis' => 'cost'],
        ]);
    }
}
