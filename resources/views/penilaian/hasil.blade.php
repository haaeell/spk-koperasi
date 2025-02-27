@extends('layouts.app')

@section('title', 'Hasil Penilaian Koperasi')
@section('breadcrumb', 'Hasil Penilaian')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Normalisasi Skor per Sub-Kriteria</h5>
                   <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" rowspan="2">Koperasi</th>
                                @foreach ($kriterias as $kriteria)
                                    <th class="text-center text-nowrap" colspan="{{ $kriteria->subKriteria->count() }}">{{ $kriteria->nama }}</th>
                                @endforeach
                                <th class="text-center text-nowrap" rowspan="2">Total Skor</th>
                            </tr>
                            <tr>
                                @foreach ($kriterias as $kriteria)
                                    @foreach ($kriteria->subKriteria as $subKriteria)
                                        <th class="text-center text-nowrap">{{ $subKriteria->nama }}</th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($koperasis as $koperasi)
                                <tr>
                                    <td class="text-nowrap">{{ $koperasi->nama }}</td>
                                    @foreach ($kriterias as $kriteria)
                                        @foreach ($kriteria->subKriteria as $subKriteria)
                                            <td class="text-center text-nowrap">
                                                {{ isset($normalisasi[$koperasi->id][$subKriteria->id]) ? number_format($normalisasi[$koperasi->id][$subKriteria->id], 2) : 0 }}
                                            </td>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center text-nowrap">
                                        {{ isset($nilaiUtility[$koperasi->id]) ? number_format($nilaiUtility[$koperasi->id]['skor'], 2) : 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   </div>
                </div>
            </div>

            <!-- Ranking Koperasi Based on Total Skor -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Ranking Koperasi Berdasarkan Skor</h5>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Ranking</th>
                                <th class="text-center">Koperasi</th>
                                <th class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiUtility as $index => $data)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $data['koperasi'] }}</td>
                                    <td class="text-center">{{ number_format($data['skor'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
