@extends('layouts.app')

@section('title', 'Edit Koperasi')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('koperasi.update', $koperasi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label>kOde</label>
                    <input type="text" name="kode" value="{{ $koperasi->kode }}" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Nama Koperasi</label>
                    <input type="text" name="nama" value="{{ $koperasi->nama }}" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="{{ $koperasi->alamat }}" class="form-control" required>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('koperasi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
