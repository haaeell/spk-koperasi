@extends('layouts.app')

@section('title', 'Tambah Sub kriteria')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sub-kriteria.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label>Kriteria</label>
                    <select name="kriteria_id" id="kriteria_id" class="form-select form-control">
                       @foreach ($kriteria as $item)
                           <option value="{{ $item->id }}">{{ $item->nama }}</option>
                       @endforeach
                    </select>
                </div>
                <div class="mb-5">
                    <label>Nama Sub Kriteria</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control" required>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
