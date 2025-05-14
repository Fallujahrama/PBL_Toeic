<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjianModel;
use App\Models\JadwalModel;
use Illuminate\Support\Facades\Storage;

class HasilUjianController extends Controller
{
    // Menampilkan daftar hasil ujian
    public function index()
    {
        $hasilUjian = HasilUjianModel::with('jadwal')->get();
        return view('hasil_ujian.index', compact('hasilUjian'));
    }

    // Menampilkan form untuk upload hasil ujian
    public function create()
    {
        $jadwal = JadwalModel::all(); // Ambil semua jadwal
        return view('hasil_ujian.create', compact('jadwal'));
    }

    // Menyimpan hasil ujian baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'file_nilai' => 'required|file|mimes:pdf,doc,docx,xlsx|max:2048',
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
        ]);

        $filePath = $request->file('file_nilai')->store('hasil_ujian_files', 'public');

        HasilUjianModel::create([
            'tanggal' => $request->tanggal,
            'file_nilai' => $filePath,
            'jadwal_id' => $request->jadwal_id,
        ]);

        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil diupload.');
    }

    // Menghapus hasil ujian
    public function destroy($id)
    {
        $hasilUjian = HasilUjianModel::findOrFail($id);

        if ($hasilUjian->file_nilai && Storage::disk('public')->exists($hasilUjian->file_nilai)) {
            Storage::disk('public')->delete($hasilUjian->file_nilai);
        }

        $hasilUjian->delete();

        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil dihapus.');
    }
}
