@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Koperasi</h2>
    <a href="{{ route('koperasi.create') }}" class="btn btn-primary mb-3">Tambah Koperasi</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($koperasis as $key => $koperasi)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $koperasi->nama }}</td>
                <td>{{ $koperasi->alamat }}</td>
                <td>
                    <a href="{{ route('koperasi.edit', $koperasi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('koperasi.destroy', $koperasi->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus Koperasi?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
