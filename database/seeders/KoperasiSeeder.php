<?php

namespace Database\Seeders;

use App\Models\Koperasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KoperasiSeeder extends Seeder
{
    public function run(): void
    {
        Koperasi::insert([
            ['nama' => 'Koperasi A', 'alamat' => 'Jl. Merdeka No. 1'],
            ['nama' => 'Koperasi B', 'alamat' => 'Jl. Sudirman No. 2'],
            ['nama' => 'Koperasi C', 'alamat' => 'Jl. Diponegoro No. 3'],
        ]);
    }
}
