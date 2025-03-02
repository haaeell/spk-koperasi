@extends('layouts.app')
@section('title', 'Penilaian Koperasi')
@section('breadcrumb', 'Penilaian')

@section('content')
    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        <div class="accordion" id="accordionPenilaian">
            @foreach ($kriterias as $index => $kriteria)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                            aria-controls="collapse{{ $index }}">
                            {{ $kriteria->nama }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}"
                        class="accordion-collapse collapse @if ($index == 0) show @endif"
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionPenilaian">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-light-dark fw-bold">
                                            <th class="text-center">Koperasi</th>
                                            @foreach ($kriteria->subKriteria as $subKriteria)
                                                <th class="text-center text-nowrap">{{ $subKriteria->kode }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($koperasis as $koperasi)
                                            <tr>
                                                <td class="text-nowrap">{{ $koperasi->kode }}</td>
                                                @foreach ($kriteria->subKriteria as $subKriteria)
                                                    @php
                                                        $key = $koperasi->id . '-' . $subKriteria->id;
                                                        $nilaiSebelumnya = $nilaiAlternatif[$key]->nilai ?? '';
                                                    @endphp
                                                    <td>
                                                        <input type="number" step="0.01"
                                                            name="nilai[{{ $koperasi->id }}][{{ $subKriteria->id }}]"
                                                            class="form-control nilai-input w-75px"
                                                            value="{{ $nilaiSebelumnya ? number_format($nilaiSebelumnya, 0) : 0 }}"
                                                            required>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary float-end">Simpan Penilaian</button>
        </div>
    </form>
     <form action="{{ route('penilaian.reset') }}" method="POST" class="d-inline" id="resetForm">
        @csrf
        @method('DELETE')
        <button type="button" id="resetDatabaseBtn" class="btn btn-danger float-start">Reset Perhitungan</button>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('resetDatabaseBtn').addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mereset semua perhitungan?')) {
                document.getElementById('resetForm').submit();
            }
        });
    </script>
@endpush
