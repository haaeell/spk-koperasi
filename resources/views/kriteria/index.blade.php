@extends('layouts.app')

@section('title', 'Data kriteria')
@section('breadcrumb', 'kriteria')
@section('content')
    <div class="card mb-5 mb-xl-8">

        <div class="card-header border-0 pt-5">
            @if (!Auth::user()->isOwner())
                <div class="card-toolbar">
                    <a href="{{ route('kriteria.create') }}" class="btn btn-sm fw-bold btn-primary">Tambah
                        kriteria</a>
                </div>
            @endif
        </div>
        <div class="card-body pt-3">

            <table class="table table-hover table-row-bordered table-row-gray-100 align-middle gs-7 gy-5" id="datatable">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800 bg-light-dark">
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Bobot</th>
                        <th>Bobot Normalisasi</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriterias as $kriteria)
                        <tr>
                            <td>{{ $kriteria->kode }}</td>
                            <td>{{ $kriteria->nama }}</td>
                            <td>{{ number_format($kriteria->bobot) }}</td>
                            <td>{{ $kriteria->bobot / 100 }}0</td>
                            <td>{{ $kriteria->jenis }}</td>
                            <td>
                                <a href="{{ route('kriteria.edit', $kriteria->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus kriteria?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
