<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubKriteria;
use App\Models\Kriteria;

class SubKriteriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Organisasi (A) - Bobot utama 25%
            ['kode' => 'A1', 'nama' => 'Simpanan Pokok Anggota', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A2', 'nama' => 'Simpanan Wajib Anggota', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A3', 'nama' => 'Penyelenggaraan Rapat Anggota', 'bobot' => 3, 'kriteria_kode' => 'A'],
            ['kode' => 'A4', 'nama' => 'Rasio Kehadiran Anggota dalam RAT', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A5', 'nama' => 'Rencana Kerja (RK) dan RAPB', 'bobot' => 3, 'kriteria_kode' => 'A'],
            ['kode' => 'A6', 'nama' => 'Rasio Peningkatan Jumlah Anggota', 'bobot' => 1, 'kriteria_kode' => 'A'],
            ['kode' => 'A7', 'nama' => 'Pendidikan dan Pelatihan bagi Anggota', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A8', 'nama' => 'Pendidikan dan Pelatihan bagi Pengelola', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A9', 'nama' => 'Tersedia Anggaran Khusus untuk Pendidikan', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A10', 'nama' => 'Pemeriksaan (Audit)', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A11', 'nama' => 'Kinerja Pengurus', 'bobot' => 2, 'kriteria_kode' => 'A'],
            ['kode' => 'A12', 'nama' => 'Pola Pengkaderan', 'bobot' => 1, 'kriteria_kode' => 'A'],
            ['kode' => 'A13', 'nama' => 'Tertib Administrasi Organisasi', 'bobot' => 1, 'kriteria_kode' => 'A'],

            // Tatalaksana dan Manajemen (B) - Bobot utama 21%
            ['kode' => 'B1', 'nama' => 'Ratio Peningkatan Keanggotaan', 'bobot' => 2, 'kriteria_kode' => 'B'],
            ['kode' => 'B2', 'nama' => 'Realisasi Anggaran Pendapatan', 'bobot' => 3, 'kriteria_kode' => 'B'],
            ['kode' => 'B3', 'nama' => 'Realisasi Anggaran Belanja', 'bobot' => 3, 'kriteria_kode' => 'B'],
            ['kode' => 'B4', 'nama' => 'Realisasi Surplus Hasil Usaha', 'bobot' => 2, 'kriteria_kode' => 'B'],
            ['kode' => 'B5', 'nama' => 'Keterkaitan Usaha Koperasi dengan Anggota', 'bobot' => 4, 'kriteria_kode' => 'B'],
            ['kode' => 'B6', 'nama' => 'Penerangan dan Penyuluhan', 'bobot' => 2, 'kriteria_kode' => 'B'],
            ['kode' => 'B7', 'nama' => 'Media Informasi', 'bobot' => 2, 'kriteria_kode' => 'B'],
            ['kode' => 'B8', 'nama' => 'Sarana Kantor dan Sarana Usaha', 'bobot' => 3, 'kriteria_kode' => 'B'],

            // Produktivitas (C) - Bobot utama 27%
            ['kode' => 'C1', 'nama' => 'Rentabilitas Modal Sendiri', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C2', 'nama' => 'Return on Asset', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C3', 'nama' => 'Asset Turn Over', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C4', 'nama' => 'Profitabilitas', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C5', 'nama' => 'Likuiditas', 'bobot' => 3, 'kriteria_kode' => 'C'],
            ['kode' => 'C6', 'nama' => 'Solvabilitas', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C7', 'nama' => 'Perputaran Piutang', 'bobot' => 3, 'kriteria_kode' => 'C'],
            ['kode' => 'C8', 'nama' => 'Struktur Pemodalan', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C9', 'nama' => 'Kepatuhan Terhadap Peraturan', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C10', 'nama' => 'Tertib Administrasi Keuangan', 'bobot' => 2, 'kriteria_kode' => 'C'],
            ['kode' => 'C11', 'nama' => 'Efisiensi Operasional', 'bobot' => 3, 'kriteria_kode' => 'C'],

            // Manfaat dan Dampak (D) - Bobot utama 17%
            ['kode' => 'D1', 'nama' => 'Keterkaitan Usaha dengan Anggota', 'bobot' => 1, 'kriteria_kode' => 'D'],
            ['kode' => 'D2', 'nama' => 'Transaksi Usaha dengan Anggota', 'bobot' => 2, 'kriteria_kode' => 'D'],
            ['kode' => 'D3', 'nama' => 'Pelayanan Usaha untuk Masyarakat', 'bobot' => 1, 'kriteria_kode' => 'D'],
            ['kode' => 'D4', 'nama' => 'Dana Sosial', 'bobot' => 4, 'kriteria_kode' => 'D'],
            ['kode' => 'D5', 'nama' => 'Dampak terhadap Kesejahteraan Anggota', 'bobot' => 2, 'kriteria_kode' => 'D'],
            ['kode' => 'D6', 'nama' => 'Pemberdayaan Ekonomi Lokal', 'bobot' => 4, 'kriteria_kode' => 'D'],
            ['kode' => 'D7', 'nama' => 'Partisipasi dalam Program Pemerintah', 'bobot' => 1, 'kriteria_kode' => 'D'],

            // Pengembangan dan Daya Saing (E) - Bobot utama 10%
            ['kode' => 'E1', 'nama' => 'Kerjasama Horizontal', 'bobot' => 2, 'kriteria_kode' => 'E'],
            ['kode' => 'E2', 'nama' => 'Kerjasama Vertikal', 'bobot' => 2, 'kriteria_kode' => 'E'],
            ['kode' => 'E3', 'nama' => 'Kerjasama dengan Badan Usaha Lain', 'bobot' => 2, 'kriteria_kode' => 'E'],
            ['kode' => 'E4', 'nama' => 'Manfaat Kerjasama', 'bobot' => 2, 'kriteria_kode' => 'E'],
            ['kode' => 'E5', 'nama' => 'Inovasi dalam Usaha', 'bobot' => 2, 'kriteria_kode' => 'E'],
        ];

        foreach ($data as $item) {
            $kriteria = Kriteria::where('kode', $item['kriteria_kode'])->first();
            if ($kriteria) {
                SubKriteria::create([
                    'kode' => $item['kode'],
                    'nama' => $item['nama'],
                    'bobot' => $item['bobot'],
                    'kriteria_id' => $kriteria->id,
                ]);
            }
        }
    }
}
