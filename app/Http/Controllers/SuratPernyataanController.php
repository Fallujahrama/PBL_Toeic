<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPernyataanModel;
use App\Models\MahasiswaModel;

class SuratPernyataanController extends Controller
{
    // Menampilkan daftar surat pernyataan
    public function index()
    {
        $suratPernyataan = SuratPernyataanModel::with('mahasiswa')->get();
        return view('surat_pernyataan.index', compact('suratPernyataan'));
    }

    // Memvalidasi surat pernyataan
    public function validateSurat($id)
    {
        $surat = SuratPernyataanModel::findOrFail($id);
        $surat->update(['status' => 'valid']);
        return redirect()->route('surat_pernyataan.index')->with('success', 'Surat pernyataan berhasil divalidasi.');
    }

    // Menolak surat pernyataan
    public function rejectSurat($id)
    {
        $surat = SuratPernyataanModel::findOrFail($id);
        $surat->update(['status' => 'rejected']);
        return redirect()->route('surat_pernyataan.index')->with('success', 'Surat pernyataan berhasil ditolak.');
    }

    public function createMahasiswa()
    {
        // Ambil data mahasiswa berdasarkan user yang login
        $mahasiswa = auth()->user()->mahasiswa; // Pastikan relasi user ke mahasiswa sudah ada
        return view('surat_pernyataan.upload', compact('mahasiswa'));
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'file_surat_pernyataan' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file_surat_pernyataan')->store('surat_pernyataan_files', 'public');

        SuratPernyataanModel::create([
            'nim' => auth()->user()->username, // Ambil NIM dari user yang login
            'file_surat_pernyataan' => $filePath,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('surat_pernyataan.createMahasiswa')->with('success', 'Surat pernyataan berhasil diupload.');
    }
}
