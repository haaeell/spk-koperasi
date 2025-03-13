<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Alternatif;
use App\Models\RiwayatPerhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenilaianController extends Controller
{
    public function index()
    {
        $koperasis = Koperasi::orderByRaw("CAST(SUBSTRING(kode, 2, LENGTH(kode)) AS UNSIGNED) ASC")->get();
        $kriterias = Kriteria::with('subKriteria')->orderByRaw("CAST(SUBSTRING(kode, 2, LENGTH(kode)) AS UNSIGNED) ASC")->get();
        $nilaiAlternatif = Alternatif::all()->keyBy(fn($item) => $item->koperasi_id . '-' . $item->sub_kriteria_id);

        return view('penilaian.index', compact('koperasis', 'kriterias', 'nilaiAlternatif'));
    }

    public function store(Request $request)
    {
        foreach ($request->nilai as $koperasiId => $subKriteriaArray) {
            foreach ($subKriteriaArray as $subKriteriaId => $nilai) {
                $subKriteria = SubKriteria::findOrFail($subKriteriaId);

                Alternatif::updateOrCreate(
                    ['koperasi_id' => $koperasiId, 'kriteria_id' => $subKriteria->kriteria_id, 'sub_kriteria_id' => $subKriteriaId],
                    ['nilai' => $nilai]
                );
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil disimpan.');
    }

    public function hitungPerhitungan()
    {
        $koperasis = Koperasi::all();
        $kriterias = Kriteria::with('subKriteria')->get();
        $alternatif = Alternatif::all();

        $cmin = [];
        $cmax = [];

        foreach ($kriterias as $kriteria) {
            foreach ($kriteria->subKriteria as $sub) {
                $nilaiSub = $alternatif->where('sub_kriteria_id', $sub->id)->pluck('nilai');
                $cmin[$sub->id] = $nilaiSub->min();
                $cmax[$sub->id] = $nilaiSub->max();
            }
        }

        $utility = [];

        foreach ($alternatif as $alt) {
            $cMin = $cmin[$alt->sub_kriteria_id];
            $cMax = $cmax[$alt->sub_kriteria_id];

            $sub = $kriterias->flatMap(function ($kriteria) {
                return $kriteria->subKriteria;
            })->where('id', $alt->sub_kriteria_id)->first();

            $jenisKriteria = $sub->kriteria->jenis;

            if ($jenisKriteria == 'cost') {
                $utility[$alt->koperasi_id][$alt->sub_kriteria_id] = ($cMax - $cMin) != 0 ? ($cMax - $alt->nilai) / ($cMax - $cMin) : 0;
            } else {
                $utility[$alt->koperasi_id][$alt->sub_kriteria_id] = ($cMax - $cMin) != 0 ? ($alt->nilai - $cMin) / ($cMax - $cMin) : 0;
            }
        }

        $skorTerbobot = [];

        foreach ($utility as $koperasiId => $subKriteria) {
            foreach ($subKriteria as $subKriteriaId => $nilaiUtility) {
                $bobotSub = SubKriteria::find($subKriteriaId)->bobot;
                $skorTerbobot[$koperasiId][$subKriteriaId] = $nilaiUtility * ($bobotSub / 100);
            }
        }

        $totalSkorPerKriteria = [];

        foreach ($koperasis as $koperasi) {
            foreach ($kriterias as $kriteria) {
                $totalSkorPerKriteria[$koperasi->id][$kriteria->id] = 0;
                foreach ($kriteria->subKriteria as $sub) {
                    $totalSkorPerKriteria[$koperasi->id][$kriteria->id] += $skorTerbobot[$koperasi->id][$sub->id] ?? 0;
                }
            }
        }

        $nilaiAkhirPerKriteria = [];

        foreach ($koperasis as $koperasi) {
            foreach ($kriterias as $kriteria) {
                $nilaiAkhirPerKriteria[$koperasi->id][$kriteria->id] = $totalSkorPerKriteria[$koperasi->id][$kriteria->id] * ($kriteria->bobot / 100);
            }
        }

        $nilaiAkhirTotal = [];

        foreach ($koperasis as $koperasi) {
            $nilaiAkhirTotal[$koperasi->id] = 0;
            foreach ($kriterias as $kriteria) {
                $nilaiAkhirTotal[$koperasi->id] += $totalSkorPerKriteria[$koperasi->id][$kriteria->id] * ($kriteria->bobot / 100);
            }
        }

        return compact('koperasis', 'kriterias', 'utility', 'skorTerbobot', 'totalSkorPerKriteria', 'nilaiAkhirPerKriteria', 'nilaiAkhirTotal');
    }
    
    public function reset()
    {
        Alternatif::truncate();

        return redirect()->route('penilaian.index')->with('success', 'Perhitungan berhasil direset.');
    }


    public function perhitungan()
    {
        $cekPenilaian = Alternatif::count();

        if ($cekPenilaian == 0) {
            return redirect()->route('penilaian.index')->with('error', 'Silakan isi penilaian terlebih dahulu.');
        }

        return view('penilaian.perhitungan', $this->hitungPerhitungan());
    }

    public function hasil()
    {
        $cekPenilaian = Alternatif::count();

        if ($cekPenilaian == 0) {
            return redirect()->route('penilaian.index')->with('error', 'Silakan isi penilaian terlebih dahulu.');
        }

        $data = $this->hitungPerhitungan();
        $peringkatKoperasi = collect($data['nilaiAkhirTotal'])->map(fn($nilai, $id) => (object) [
            'id' => $id,
            'kode' => Koperasi::find($id)->kode,
            'nilai_akhir' => $nilai,
            'nama' => Koperasi::find($id)->nama
        ])->sortByDesc('nilai_akhir')->values()->all();

        return view('penilaian.hasil', compact('peringkatKoperasi'));
    }
    public function simpanHasil(Request $request)
    {
        $dataPerhitungan = json_decode($request->input('data_perhitungan'));

        if (!$dataPerhitungan) {
            return redirect()->back()->with('error', 'Data perhitungan tidak valid.');
        }

        DB::beginTransaction();
        try {
            foreach ($dataPerhitungan as $index => $koperasi) {
                RiwayatPerhitungan::create([
                    'kode_koperasi' => $koperasi->kode,
                    'nilai_akhir' => $koperasi->nilai_akhir,
                    'peringkat' => $index + 1
                ]);
            }

            DB::commit();
            return redirect()->route('riwayat')->with('success', 'Hasil perhitungan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('riwayat')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function riwayat()
    {
        $riwayat = RiwayatPerhitungan::select('peringkat', 'kode_koperasi', 'nilai_akhir', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('d-m-Y'));

        return view('riwayat-perhitungan', compact('riwayat'));
    }
}
