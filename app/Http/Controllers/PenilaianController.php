<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Alternatif;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $koperasis = Koperasi::orderBy('nama', 'asc')->get();
        $kriterias = Kriteria::with('subKriteria')->get();
        $nilaiAlternatif = Alternatif::all()->keyBy(function ($item) {
            return $item->koperasi_id . '-' . $item->sub_kriteria_id;
        });

        return view('penilaian.index', compact('koperasis', 'kriterias', 'nilaiAlternatif'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nilai' => 'required|array',
        ]);

        foreach ($validatedData['nilai'] as $koperasiId => $subKriteriaData) {
            foreach ($subKriteriaData as $subKriteriaId => $nilai) {
                Alternatif::updateOrCreate(
                    [
                        'koperasi_id' => $koperasiId,
                        'sub_kriteria_id' => $subKriteriaId,
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
        $kriterias = Kriteria::with('subKriteria')->get();
        $subKriterias = SubKriteria::all();

        $alternatifs = Alternatif::all();

        $normalisasi = [];
        foreach ($koperasis as $koperasi) {
            foreach ($subKriterias as $subKriteria) {
                $nilai = Alternatif::where('koperasi_id', $koperasi->id)
                    ->where('sub_kriteria_id', $subKriteria->id)
                    ->first()
                    ->nilai ?? 0;

                if ($subKriteria->jenis == 'benefit') {
                    $max = Alternatif::where('sub_kriteria_id', $subKriteria->id)->max('nilai');
                    $normalisasi[$koperasi->id][$subKriteria->id] = $max ? ($nilai / $max) : 0;
                } else {
                    $min = Alternatif::where('sub_kriteria_id', $subKriteria->id)->min('nilai');
                    $normalisasi[$koperasi->id][$subKriteria->id] = $min ? ($min / $nilai) : 0;
                }
            }
        }

        $nilaiUtility = [];
        foreach ($koperasis as $koperasi) {
            $total = 0;
            foreach ($subKriterias as $subKriteria) {
                $total += $normalisasi[$koperasi->id][$subKriteria->id] * $subKriteria->bobot;
            }
            $nilaiUtility[] = [
                'koperasi' => $koperasi->nama,
                'skor' => $total,
            ];
        }

        usort($nilaiUtility, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        return view('penilaian.hasil', compact('koperasis', 'kriterias', 'normalisasi', 'nilaiUtility'));
    }
}
