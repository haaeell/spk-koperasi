<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subKriterias = SubKriteria::orderBy('kode', 'asc')->get();
        return view('sub-kriteria.index', compact('subKriterias'));
    }

    public function create()
    {
        $kriteria = Kriteria::all();
        return view('sub-kriteria.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required',
            'kriteria_id' => 'required',
        ]);

        SubKriteria::create($request->all());
        return redirect()->route('sub-kriteria.index')->with('success', 'Sub Kriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $kriteria = Kriteria::all();
        return view('sub-kriteria.edit', compact('subKriteria', 'kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required',
            'kriteria_id' => 'required',
        ]);

        $kriteria->update($request->all());
        return redirect()->route('sub-kriteria.index')->with('success', 'Sub Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $subKriteria->delete();
        return redirect()->route('sub-kriteria.index')->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}
