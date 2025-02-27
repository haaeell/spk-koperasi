@extends('layouts.app')

@section('title', 'Tambah Koperasi')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('koperasi.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label>Nama Koperasi</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Kode</label>
                    <input type="text" name="kode" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('koperasi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
