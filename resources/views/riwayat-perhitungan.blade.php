@extends('layouts.app')
@section('title', 'Riwayat Perhitungan')

@section('content')

    <h4 class="mt-4">Riwayat Perhitungan</h4>

    @foreach ($riwayat as $tanggal => $dataGroup)
        <h5 class="mt-3">{{ \Carbon\Carbon::parse($tanggal)->locale('id')->format('d F Y') }}</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>Peringkat</th>
                        <th>Kode Koperasi</th>
                        <th>Nilai Akhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataGroup as $data)
                        <tr class="{{ $data->peringkat == 1 ? 'table-success fw-bold' : '' }}">
                            <td>{{ $data->peringkat }}</td>
                            <td>{{ $data->kode_koperasi }}</td>
                            <td>{{ number_format($data->nilai_akhir, 4) }}</td>
                            <td>{{ $data->peringkat == 1 ? '🏆 Koperasi Terbaik' : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

@endsection
