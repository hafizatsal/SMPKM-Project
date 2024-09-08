<?php

namespace App\Http\Controllers;

use App\Models\GuruMataPelajaran;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class GuruMataPelajaranController extends Controller
{
    public function index()
    {
        $guruMataPelajarans = GuruMataPelajaran::all();
        return view('guru_mata_pelajaran.index', compact('guruMataPelajarans'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        return view('guru_mata_pelajaran.create', compact('gurus', 'mataPelajarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ]);

        GuruMataPelajaran::create($request->all());

        return redirect()->route('guru_mata_pelajaran.index')->with('success', 'Guru Mata Pelajaran created successfully.');
    }

    public function edit(GuruMataPelajaran $guruMataPelajaran)
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        return view('guru_mata_pelajaran.edit', compact('guruMataPelajaran', 'gurus', 'mataPelajarans'));
    }

    public function update(Request $request, GuruMataPelajaran $guruMataPelajaran)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ]);

        $guruMataPelajaran->update($request->all());

        return redirect()->route('guru_mata_pelajaran.index')->with('success', 'Guru Mata Pelajaran updated successfully.');
    }

    public function destroy(GuruMataPelajaran $guruMataPelajaran)
    {
        $guruMataPelajaran->delete();
        return redirect()->route('guru_mata_pelajaran.index')->with('success', 'Guru Mata Pelajaran deleted successfully.');
    }
}
