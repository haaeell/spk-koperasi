@extends('layouts.app')
@section('title', 'Riwayat Perhitungan')

@section('content')

    <h4 class="mt-4">Riwayat Perhitungan</h4>

    @foreach ($riwayat as $tanggal => $dataGroup)
        <button class="mt-3 btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#modal{{ \Str::slug($tanggal) }}">
            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </button>

        <div class="modal fade" id="modal{{ \Str::slug($tanggal) }}" tabindex="-1" aria-labelledby="modalLabel{{ \Str::slug($tanggal) }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ \Str::slug($tanggal) }}">Detail Perhitungan - {{ \Carbon\Carbon::parse($tanggal)->locale('id')->format('d F Y') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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

                        <h6>Deskripsi:</h6>
                        <p>Hasil perhitungan untuk koperasi dengan kode masing-masing menunjukkan bahwa nilai akhir yang dihitung berdasarkan kriteria yang telah ditetapkan, dengan koperasi terbaik terpilih berdasarkan bobot dan hasil perhitungan. Koperasi dengan nilai akhir tertinggi menerima status "🏆 Koperasi Terbaik".</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
