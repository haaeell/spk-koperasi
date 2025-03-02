@extends('layouts.app')

@section('title', 'Edit kriteria')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sub-kriteria.update', $subKriteria->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label>Kriteria</label>
                    <select name="kriteria_id" id="kriteria_id" class="form-select form-control">
                       @foreach ($kriteria as $item)
                           <option value="{{ $item->id }}" {{ $item->id == $subKriteria->kriteria_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                       @endforeach
                    </select>
                </div>
                <div class="mb-5">
                    <label>Nama Sub Kriteria</label>
                    <input type="text" name="nama" value="{{ $subKriteria->nama }}" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Kode</label>
                    <input type="text" name="kode" value="{{ $subKriteria->kode }}" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label>Bobot</label>
                    <input type="number" step="0.01" value="{{ number_format($subKriteria->bobot, 0) }}" name="bobot" class="form-control" required>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
