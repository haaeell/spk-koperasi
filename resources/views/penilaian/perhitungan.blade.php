@extends('layouts.app')
@section('title', 'Hasil Penilaian Koperasi')

@section('content')
    <div class="">
        {{-- 1. Tabel Nilai Utility --}}
        <h4 class="mt-4">Nilai Utility</h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th rowspan="2">Koperasi</th>
                        @foreach ($kriterias as $kriteria)
                            <th colspan="{{ count($kriteria->subKriteria) }}">{{ $kriteria->nama }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($kriterias as $kriteria)
                            @foreach ($kriteria->subKriteria as $sub)
                                <th>{{ $sub->kode }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($koperasis as $koperasi)
                        <tr>
                            <td class="text-nowrap">{{ $koperasi->kode }}</td>
                            @foreach ($kriterias as $kriteria)
                                @foreach ($kriteria->subKriteria as $sub)
                                    <td>{{ number_format($utility[$koperasi->id][$sub->id] ?? 0, 4) }}</td>
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 2. Tabel Total Skor Terbobot per Kriteria --}}
        <h4 class="mt-4">Total Skor Terbobot per Kriteria</h4>
        <table class="table table-bordered text-center">
            <thead class="table-warning">
                <tr>
                    <th>Koperasi</th>
                    @foreach ($kriterias as $kriteria)
                        <th>{{ $kriteria->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($koperasis as $koperasi)
                    <tr>
                        <td>{{ $koperasi->kode }}</td>
                        @foreach ($kriterias as $kriteria)
                            <td>{{ number_format($totalSkorPerKriteria[$koperasi->id][$kriteria->id] ?? 0, 4) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 3. Tabel Nilai Akhir per Kriteria & Total --}}
        <h4 class="mt-4">Nilai Akhir per Kriteria & Total</h4>
        <table class="table table-bordered text-center">
            <thead class="table-success">
                <tr>
                    <th rowspan="2">Koperasi</th>
                    @foreach ($kriterias as $kriteria)
                        <th class="text-nowrap">{{ $kriteria->nama }}</th>
                    @endforeach
                    <th rowspan="2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($koperasis as $koperasi)
                    <tr>
                        <td class="text-nowrap">{{ $koperasi->kode }}</td>
                        @foreach ($kriterias as $kriteria)
                            <td>{{ number_format($nilaiAkhirPerKriteria[$koperasi->id][$kriteria->id] ?? 0, 4) }}</td>
                        @endforeach
                        <td class="fw-bold">{{ number_format($nilaiAkhirTotal[$koperasi->id] ?? 0, 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/hasil" class="btn btn-primary mt-4">Lihat Hasil Perangkingan</a>
    </div>
@endsection
