<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use Illuminate\Http\Request;

class KoperasiController extends Controller
{
    public function index()
    {
        $koperasis = Koperasi::orderByRaw("CAST(SUBSTRING(kode, 2, LENGTH(kode)) AS UNSIGNED) ASC")->get();
        return view('koperasi.index', compact('koperasis'));
    }

    public function create()
    {
        return view('koperasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        Koperasi::create($request->all());
        return redirect()->route('koperasi.index')->with('success', 'Koperasi berhasil ditambahkan.');
    }

    public function edit(Koperasi $koperasi)
    {
        return view('koperasi.edit', compact('koperasi'));
    }

    public function update(Request $request, Koperasi $koperasi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        $koperasi->update($request->all());
        return redirect()->route('koperasi.index')->with('success', 'Koperasi berhasil diperbarui.');
    }

    public function destroy(Koperasi $koperasi)
    {
        $koperasi->delete();
        return redirect()->route('koperasi.index')->with('success', 'Koperasi berhasil dihapus.');
    }
}
