<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\Koperasi;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;

class AlternatifSeeder extends Seeder
{
    public function run(): void
    {
        $koperasis = Koperasi::all();
        $kriterias = Kriteria::all();

        foreach ($koperasis as $koperasi) {
            foreach ($kriterias as $kriteria) {
                $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)->inRandomOrder()->first();
                
                Alternatif::create([
                    'koperasi_id' => $koperasi->id,
                    'kriteria_id' => $kriteria->id,
                    'sub_kriteria_id' => $subKriteria ? $subKriteria->id : null,
                    'nilai' => rand(50, 100) / 10,
                ]);
            }
        }
    }
}
