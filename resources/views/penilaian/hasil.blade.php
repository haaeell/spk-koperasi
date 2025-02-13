@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Hasil Perhitungan SMART</h2>

    <h3>Normalisasi Nilai</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Koperasi</th>
                @foreach($kriterias as $kriteria)
                    <th>{{ $kriteria->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($koperasis as $koperasi)
            <tr>
                <td>{{ $koperasi->nama }}</td>
                @foreach($kriterias as $kriteria)
                    <td>{{ number_format($normalisasi[$koperasi->id][$kriteria->id], 4) }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Nilai Utility (Skor Akhir)</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Koperasi</th>
                <th>Skor Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiUtility as $index => $hasil)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $hasil['koperasi'] }}</td>
                <td>{{ number_format($hasil['skor'], 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
