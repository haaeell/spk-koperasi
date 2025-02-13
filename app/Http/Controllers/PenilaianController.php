<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $koperasis = Koperasi::orderBy('nama', 'asc')->get();
        $kriterias = Kriteria::all();
        $nilaiAlternatif = Alternatif::all()->keyBy(function ($item) {
            return $item->koperasi_id . '-' . $item->kriteria_id;
        });

        return view('penilaian.index', compact('koperasis', 'kriterias', 'nilaiAlternatif'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nilai' => 'required|array',
        ]);

        foreach ($validatedData['nilai'] as $koperasiId => $kriteriaData) {
            foreach ($kriteriaData as $kriteriaId => $nilai) {
                Alternatif::updateOrCreate(
                    [
                        'koperasi_id' => $koperasiId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }

        return redirect()->route('penilaian.proses')->with('success', 'Data penilaian berhasil disimpan.');
    }


    public function proses()
    {
        $koperasis = Koperasi::all();
        $kriterias = Kriteria::all();
    
        // Ambil semua nilai alternatif
        $alternatifs = Alternatif::all();
    
        // Normalisasi
        $normalisasi = [];
        foreach ($koperasis as $koperasi) {
            foreach ($kriterias as $kriteria) {
                $nilai = Alternatif::where('koperasi_id', $koperasi->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->first()
                    ->nilai ?? 0;
    
                if ($kriteria->jenis == 'benefit') {
                    $max = Alternatif::where('kriteria_id', $kriteria->id)->max('nilai');
                    $normalisasi[$koperasi->id][$kriteria->id] = $max ? ($nilai / $max) : 0;
                } else { // Cost
                    $min = Alternatif::where('kriteria_id', $kriteria->id)->min('nilai');
                    $normalisasi[$koperasi->id][$kriteria->id] = $min ? ($min / $nilai) : 0;
                }
            }
        }
    
        // Menghitung Nilai Utility (Si)
        $nilaiUtility = [];
        foreach ($koperasis as $koperasi) {
            $total = 0;
            foreach ($kriterias as $kriteria) {
                $total += $normalisasi[$koperasi->id][$kriteria->id] * $kriteria->bobot;
            }
            $nilaiUtility[] = [
                'koperasi' => $koperasi->nama,
                'skor' => $total,
            ];
        }
    
        // Urutkan berdasarkan skor tertinggi
        usort($nilaiUtility, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });
    
        return view('penilaian.hasil', compact('koperasis', 'kriterias', 'normalisasi', 'nilaiUtility'));
    }
    
}
