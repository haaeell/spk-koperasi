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
            ['nama' => 'Koperasi A','kode' => 'K1', 'alamat' => 'Jl. Merdeka No. 1'],
            ['nama' => 'Koperasi B','kode' => 'K2', 'alamat' => 'Jl. Sudirman No. 2'],
            ['nama' => 'Koperasi C','kode' => 'K3', 'alamat' => 'Jl. Diponegoro No. 3'],
            ['nama' => 'Koperasi D','kode' => 'K4', 'alamat' => 'Jl. Diponegoro No. 4'],
            ['nama' => 'Koperasi E','kode' => 'K5', 'alamat' => 'Jl. Diponegoro No. 5'],
        ]);
    }
}
