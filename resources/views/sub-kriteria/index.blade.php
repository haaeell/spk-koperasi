@extends('layouts.app')

@section('title', 'Data Sub Kriteria')
@section('breadcrumb', 'Sub Kriteria')

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            @if (!Auth::user()->isOwner())
                <div class="card-toolbar">
                    <a href="{{ route('sub-kriteria.create') }}" class="btn btn-sm fw-bold btn-primary">Tambah Sub
                        Kriteria</a>
                </div>
            @endif
        </div>
        <div class="card-body pt-3">

            <!-- NAV TABS -->
            <ul class="nav nav-tabs" id="kriteriaTabs" role="tablist">
                @foreach ($subKriterias->groupBy('kriteria_id') as $kriteriaId => $subKriteriaGroup)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $kriteriaId }}"
                            data-bs-toggle="tab" href="#content-{{ $kriteriaId }}" role="tab">
                            {{ $subKriteriaGroup->first()->kriteria->nama }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content mt-4" id="kriteriaTabsContent">
                @foreach ($subKriterias->groupBy('kriteria_id') as $kriteriaId => $subKriteriaGroup)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $kriteriaId }}"
                        role="tabpanel">

                        <table
                            class="table table-hover table-row-bordered table-row-gray-100 align-middle gs-7 gy-5 datatable">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 bg-light-dark">
                                    <th>No</th>
                                    <th>Nama Sub Kriteria</th>
                                    <th>Kode</th>
                                    <th>Bobot</th>
                                    <th>Bobot Normalisasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subKriteriaGroup as $subKriteria)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subKriteria->nama }}</td>
                                        <td>{{ $subKriteria->kode }}</td>
                                        <td>{{ number_format($subKriteria->bobot, 0) }}</td>
                                        <td>{{ $subKriteria->bobot / 100 }}</td>
                                        <td>
                                            @if (!Auth::user()->isOwner())
                                                <a href="{{ route('sub-kriteria.edit', $subKriteria->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('sub-kriteria.destroy', $subKriteria->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus sub-kriteria?')">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @php
                                    $totalBobot = $subKriteriaGroup->sum('bobot');
                                @endphp
                                <tr class="bg-light-dark">
                                    <td colspan="3" class="text-center fw-bold">Total Bobot</td>
                                    <td class="fw-bold">{{ $totalBobot }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
