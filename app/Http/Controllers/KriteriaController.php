<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::orderByRaw("CAST(SUBSTRING(kode, 2, LENGTH(kode)) AS UNSIGNED) ASC")->get();
        return view('kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required',
            'jenis' => 'required',
        ]);

        $totalBobotSaatIni = Kriteria::sum('bobot');
        $bobotBaru = $request->bobot;

        if (($totalBobotSaatIni + $bobotBaru) > 100) {
            return redirect()->back()->withErrors(['bobot' => 'Total bobot tidak boleh lebih dari 100. Total bobot saat ini adalah ' . $totalBobotSaatIni])
                ->withInput();
        }

        Kriteria::create($request->all());
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required',
            'jenis' => 'required',
            'kode' => 'required',
        ]);

        $totalBobotSaatIni = Kriteria::where('id', '!=', $id)->sum('bobot');
        $bobotBaru = $request->bobot;

        if (($totalBobotSaatIni + $bobotBaru) > 100) {
            return redirect()->back()->withErrors(['bobot' => 'Total bobot tidak boleh lebih dari 100. Total bobot saat ini adalah ' . $totalBobotSaatIni])
                ->withInput();
        }

        $kriteria->nama = $request->nama;
        $kriteria->bobot = $request->bobot;
        $kriteria->jenis = $request->jenis;
        $kriteria->kode = $request->kode;
        $kriteria->save();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
