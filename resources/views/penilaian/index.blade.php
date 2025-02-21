@extends('layouts.app')
@section('title', 'Penilaian Koperasi')
@section('breadcrumb', 'Penilaian')
@section('content')
<form action="{{ route('penilaian.store') }}" method="POST">
    @csrf
    <table class="table table-bordered table-striped" id="datatable">
        <thead>
            <tr class="bg-light-dark fw-bold">
                <th class="text-center">Koperasi</th>
                @foreach ($kriterias as $kriteria)
                    <th class="text-center">{{ $kriteria->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($koperasis as $koperasi)
                <tr>
                    <td class="text-nowrap">{{ $koperasi->nama }}</td>
                    @foreach ($kriterias as $kriteria)
                        <td>
                            @php
                                $key = $koperasi->id . '-' . $kriteria->id;
                                $nilaiSebelumnya = $nilaiAlternatif[$key]->nilai ?? '';
                            @endphp
                            <input type="number" step="0.01"
                                name="nilai[{{ $koperasi->id }}][{{ $kriteria->id }}]" class="form-control"
                                value="{{ $nilaiSebelumnya ? number_format($nilaiSebelumnya, 0) : 0 }}" required>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary float-end">Proses Penilaian</button>
</form>
@endsection
