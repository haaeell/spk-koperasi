@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Koperasi</h2>
    
    <form action="{{ route('koperasi.update', $koperasi->id) }}" method="POST"  method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Koperasi</label>
            <input type="text" name="nama" value="{{ $koperasi->nama }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ $koperasi->alamat }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('koperasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
