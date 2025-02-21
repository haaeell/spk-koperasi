@extends('layouts.app')

@section('title', 'Edit kriteria')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label>Nama Kriteria</label>
                    <input type="text" name="nama" value="{{ $kriteria->nama }}" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Bobot</label>
                    <input type="number" step="0.01" value="{{ number_format($kriteria->bobot, 2) }}" name="bobot" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Jenis</label>
                    <select name="jenis" id="jenis" class="form-select form-control">
                        <option value="cost" {{ $kriteria->jenis == 'cost' ? 'selected' : '' }}>Cost</option>
                        <option value="benefit" {{ $kriteria->jenis == 'benefit' ? 'selected' : '' }}>Benefit</option>
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
