@extends('layouts.app')

@section('title', 'Data Koperasi')
@section('breadcrumb', 'Koperasi')
@section('content')
    <div class="card mb-5 mb-xl-8">

        <div class="card-header border-0 pt-5">
            @if (!Auth::user()->isOwner())
                <div class="card-toolbar">
                    <a href="{{ route('koperasi.create') }}" class="btn btn-sm fw-bold btn-primary">Tambah
                        Koperasi</a>
                </div>
            @endif
        </div>
        <div class="card-body pt-3">

            <table class="table table-hover table-row-bordered table-row-gray-100 align-middle gs-7 gy-5" id="datatable">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800 bg-light-dark">
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($koperasis as $koperasi)
                        <tr>
                            <td>{{ $koperasi->kode }}</td>
                            <td>{{ $koperasi->nama }}</td>
                            <td>{{ $koperasi->alamat }}</td>
                            <td>
                                @if (!Auth::user()->isOwner())
                                    <a href="{{ route('koperasi.edit', $koperasi->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('koperasi.destroy', $koperasi->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus Koperasi?')">Hapus</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
