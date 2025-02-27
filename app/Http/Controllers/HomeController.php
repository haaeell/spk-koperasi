<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koperasi;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Alternatif;
use App\Models\RiwayatPerhitungan;

class HomeController extends Controller
{
    public function index()
    {
        $totalKoperasi = Koperasi::count();
        $totalKriteria = Kriteria::count();
        $totalSubKriteria = SubKriteria::count();
        $totalPenilaian = Alternatif::count();

        $latestCreatedAt = RiwayatPerhitungan::max('created_at');
        
        $rankingKoperasi = RiwayatPerhitungan::orderBy('peringkat', 'asc')->where('created_at', $latestCreatedAt)->get();
        $riwayatPenilaian = RiwayatPerhitungan::where('created_at', $latestCreatedAt)->get();
        $koperasiNames = $rankingKoperasi->pluck('kode_koperasi');
        $koperasiScores = $rankingKoperasi->pluck('nilai_akhir');

        return view('home', compact(
            'totalKoperasi',
            'totalKriteria',
            'totalSubKriteria',
            'totalPenilaian',
            'rankingKoperasi',
            'riwayatPenilaian',
            'koperasiNames',
            'koperasiScores'
        ));
    }
}
