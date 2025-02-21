<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = Kriteria::all();

        foreach ($kriterias as $kriteria) {
            SubKriteria::insert([
                ['kriteria_id' => $kriteria->id, 'nama' => 'Sangat Baik', 'bobot' => 1.0],
                ['kriteria_id' => $kriteria->id, 'nama' => 'Baik', 'bobot' => 0.75],
                ['kriteria_id' => $kriteria->id, 'nama' => 'Cukup', 'bobot' => 0.5],
                ['kriteria_id' => $kriteria->id, 'nama' => 'Kurang', 'bobot' => 0.25],
                ['kriteria_id' => $kriteria->id, 'nama' => 'Sangat Kurang', 'bobot' => 0.1],
            ]);
        }
    }
}
