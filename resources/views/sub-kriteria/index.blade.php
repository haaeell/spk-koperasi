@extends('layouts.app')

@section('title', 'Data Sub kriteria')
@section('breadcrumb', 'Sub kriteria')
@section('content')
    <div class="card mb-5 mb-xl-8">

        <div class="card-header border-0 pt-5">
            @if (!Auth::user()->isOwner())
                <div class="card-toolbar">
                    <a href="{{ route('sub-kriteria.create') }}" class="btn btn-sm fw-bold btn-primary">Tambah
                        Sub kriteria</a>
                </div>
            @endif
        </div>
        <div class="card-body pt-3">

            <table class="table table-hover table-row-bordered table-row-gray-100 align-middle gs-7 gy-5" id="datatable">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800 bg-light-dark">
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Nama Sub Kriteria</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subKriterias->groupBy('kriteria_id') as $kriteriaId => $subKriteriaGroup)
                        @foreach ($subKriteriaGroup as $subKriteria)
                            <tr>
                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                <td>{{ $subKriteria->kriteria->nama }}</td>
                                <td>{{ $subKriteria->nama }}</td>
                                <td>{{ $subKriteria->bobot }}</td>
                                <td>
                                    <a href="{{ route('sub-kriteria.edit', $subKriteria->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('sub-kriteria.destroy', $subKriteria->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus sub-kriteria?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
@endsection
