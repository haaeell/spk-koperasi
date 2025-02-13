@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Penilaian Koperasi</h2>

        <form action="{{ route('penilaian.store') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
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
                            <td>{{ $koperasi->nama }}</td>
                            @foreach ($kriterias as $kriteria)
                                <td>
                                    @php
                                        $key = $koperasi->id . '-' . $kriteria->id;
                                        $nilaiSebelumnya = $nilaiAlternatif[$key]->nilai ?? '';
                                    @endphp
                                    <input type="number" step="0.01" name="nilai[{{ $koperasi->id }}][{{ $kriteria->id }}]"
                                        class="form-control" value="{{ $nilaiSebelumnya ? number_format($nilaiSebelumnya, 0) : 0}}" required>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Proses Penilaian</button>
        </form>
    </div>
@endsection
