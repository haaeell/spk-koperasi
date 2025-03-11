@extends('layouts.app')

@section('title', 'Tambah kriteria')
@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kriteria.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label>Kode</label>
                    <input type="text" name="kode" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Nama Kriteria</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Jenis</label>
                    <select name="jenis" id="jenis" class="form-select form-control">
                        <option value="cost">Cost</option>
                        <option value="benefit">Benefit</option>
                    </select>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
