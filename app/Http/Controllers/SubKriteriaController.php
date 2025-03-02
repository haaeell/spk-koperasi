<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subKriterias = SubKriteria::orderByRaw("CAST(SUBSTRING(kode, 2, LENGTH(kode)) AS UNSIGNED) ASC")->get();
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

    public function update(Request $request, $id)
    {
        $kriteria = SubKriteria::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required',
            'kriteria_id' => 'required',
            'kode' => 'required',
        ]);

        $kriteria->nama = $request->nama;
        $kriteria->bobot = $request->bobot;
        $kriteria->kriteria_id = $request->kriteria_id;
        $kriteria->kode = $request->kode;
        $kriteria->save();

        return redirect()->route('sub-kriteria.index')->with('success', 'Sub Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $subKriteria->delete();
        return redirect()->route('sub-kriteria.index')->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}
