<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalModel;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    // Menampilkan daftar jadwal
    public function index()
    {
        $jadwal = JadwalModel::all();
        $activemenu = 'jadwal';
        return view('jadwal.index', compact('jadwal', 'activemenu'));
    }

    // Menampilkan form untuk membuat jadwal baru
    public function create()
    {
        return view('jadwal.create');
    }

    // Menyimpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'informasi' => 'required|string|max:255',
            'file_info' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_info')) {
            $filePath = $request->file('file_info')->store('jadwal_files', 'public');
        }

        JadwalModel::create([
            'tanggal' => $request->tanggal,
            'informasi' => $request->informasi,
            'file_info' => $filePath,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Menghapus jadwal
    public function destroy($id)
    {
        $jadwal = JadwalModel::findOrFail($id);

        if ($jadwal->file_info && Storage::disk('public')->exists($jadwal->file_info)) {
            Storage::disk('public')->delete($jadwal->file_info);
        }

        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    // Menampilkan form edit jadwal
    public function edit($id)
    {
        $jadwal = JadwalModel::findOrFail($id);
        return view('jadwal.edit', compact('jadwal'));
    }

    // Memperbarui jadwal
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'informasi' => 'required|string|max:255',
            'file_info' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $jadwal = JadwalModel::findOrFail($id);

        if ($request->hasFile('file_info')) {
            // Hapus file lama jika ada
            if ($jadwal->file_info && Storage::disk('public')->exists($jadwal->file_info)) {
                Storage::disk('public')->delete($jadwal->file_info);
            }
            $filePath = $request->file('file_info')->store('jadwal_files', 'public');
            $jadwal->file_info = $filePath;
        }

        $jadwal->update([
            'tanggal' => $request->tanggal,
            'informasi' => $request->informasi,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }
}
