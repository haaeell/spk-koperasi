@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Koperasi</h2>
    
    <form action="{{ route('koperasi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Koperasi</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('koperasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
