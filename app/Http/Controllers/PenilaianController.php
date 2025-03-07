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

    private function hitungPerhitungan()
    {
        // Mengambil data koperasi, kriteria, dan alternatif dari database
        $koperasis = Koperasi::all(); // Semua koperasi
        $kriterias = Kriteria::with('subKriteria')->get(); // Semua kriteria beserta sub-kriterianya
        $alternatif = Alternatif::all(); // Semua alternatif

        // Array untuk menyimpan nilai minimum dan maksimum setiap sub-kriteria
        $cmin = [];
        $cmax = [];

        // Menghitung nilai minimum dan maksimum untuk setiap sub-kriteria
        foreach ($kriterias as $kriteria) {
            foreach ($kriteria->subKriteria as $sub) {
                // Mengambil nilai alternatif berdasarkan sub-kriteria tertentu
                $nilaiSub = $alternatif->where('sub_kriteria_id', $sub->id)->pluck('nilai');
                // Menyimpan nilai minimum dan maksimum dari alternatif untuk sub-kriteria ini
                $cmin[$sub->id] = $nilaiSub->min();
                $cmax[$sub->id] = $nilaiSub->max();
            }
        }

        // Array untuk menyimpan nilai utilitas (utility) setiap alternatif
        $utility = [];

        // Menghitung nilai utilitas setiap alternatif berdasarkan normalisasi nilai alternatif terhadap nilai minimum dan maksimum
        foreach ($alternatif as $alt) {
            $cMin = $cmin[$alt->sub_kriteria_id]; // Nilai minimum sub-kriteria terkait
            $cMax = $cmax[$alt->sub_kriteria_id]; // Nilai maksimum sub-kriteria terkait

            // Normalisasi nilai: (nilai alternatif - nilai minimum) / (nilai maksimum - nilai minimum)
            // Jika nilai maksimum dan minimum sama, nilai utilitas adalah 0
            $utility[$alt->koperasi_id][$alt->sub_kriteria_id] = ($cMax - $cMin) != 0 ? ($alt->nilai - $cMin) / ($cMax - $cMin) : 0;
        }

        // Array untuk menyimpan skor terbobot setiap alternatif
        $skorTerbobot = [];

        // Mengalikan nilai utilitas dengan bobot sub-kriteria untuk mendapatkan skor terbobot
        foreach ($utility as $koperasiId => $subKriteria) {
            foreach ($subKriteria as $subKriteriaId => $nilaiUtility) {
                // Mengambil bobot sub-kriteria dan menghitung skor terbobot
                $bobotSub = SubKriteria::find($subKriteriaId)->bobot;
                $skorTerbobot[$koperasiId][$subKriteriaId] = $nilaiUtility * ($bobotSub / 100);
            }
        }

        // Array untuk menyimpan total skor per kriteria untuk setiap koperasi
        $totalSkorPerKriteria = [];

        // Menghitung total skor untuk setiap kriteria berdasarkan skor terbobot dari setiap sub-kriteria
        foreach ($koperasis as $koperasi) {
            foreach ($kriterias as $kriteria) {
                $totalSkorPerKriteria[$koperasi->id][$kriteria->id] = 0;
                foreach ($kriteria->subKriteria as $sub) {
                    // Menambahkan skor terbobot untuk setiap sub-kriteria dalam kriteria ini
                    $totalSkorPerKriteria[$koperasi->id][$kriteria->id] += $skorTerbobot[$koperasi->id][$sub->id] ?? 0;
                }
            }
        }

        // Array untuk menyimpan nilai akhir per kriteria setelah dikalikan dengan bobot kriteria
        $nilaiAkhirPerKriteria = [];

        // Mengalikan total skor per kriteria dengan bobot kriteria untuk mendapatkan nilai akhir per kriteria
        foreach ($koperasis as $koperasi) {
            foreach ($kriterias as $kriteria) {
                $nilaiAkhirPerKriteria[$koperasi->id][$kriteria->id] = 0;
                $nilaiAkhirPerKriteria[$koperasi->id][$kriteria->id] = $totalSkorPerKriteria[$koperasi->id][$kriteria->id] * ($kriteria->bobot / 100);
            }
        }

        // Array untuk menyimpan nilai akhir total untuk setiap koperasi
        $nilaiAkhirTotal = [];

        // Menghitung nilai akhir total untuk setiap koperasi berdasarkan bobot kriteria
        foreach ($koperasis as $koperasi) {
            $nilaiAkhirTotal[$koperasi->id] = 0;
            foreach ($kriterias as $kriteria) {
                // Menambahkan nilai akhir per kriteria untuk setiap koperasi
                $nilaiAkhirTotal[$koperasi->id] += $totalSkorPerKriteria[$koperasi->id][$kriteria->id] * ($kriteria->bobot / 100);
            }
        }

        // Mengembalikan hasil perhitungan dalam bentuk array
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
