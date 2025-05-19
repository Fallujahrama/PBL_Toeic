<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPernyataan;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SuratPernyataanController extends Controller
{
    public function index()
    {
    // Mendapatkan data yang diperlukan untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Pengajuan Surat Pernyataan',
            'list' => ['Home', 'Pengajuan Surat Pernyataan']
        ];

        $page = (object) [
            'title' => 'Pengajuan Surat Pernyataan'
        ];

        $activeMenu = 'Surat Pernyataan';  // Menandakan menu aktif

        $userId = auth()->user()->id_user;

        // Ambil data mahasiswa berdasarkan user_id
        $mahasiswa = \App\Models\Mahasiswa::where('user_id', $userId)->first();

        // Ambil surat berdasarkan nim mahasiswa
        $surat = SuratPernyataan::where('nim', $mahasiswa->nim)->first();

        return view('surat.index', compact('breadcrumb','page','activeMenu','mahasiswa', 'surat'));
    }

    public function create()
    {
        $user = Auth::user();
        $mahasiswa = \App\Models\Mahasiswa::where('user_id', $user->id_user)->first();

        // Ambil surat terakhir berdasarkan NIM (jika ada)
        $surat = \App\Models\SuratPernyataan::where('nim', $mahasiswa->nim)->latest()->first();

        return view('surat.create', compact('mahasiswa', 'surat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_surat_pernyataan' => 'required|mimes:pdf|max:2048',
            'nim' => 'required'
        ]);

        // Simpan file
        $file = $request->file('file_surat_pernyataan');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('surat', $filename, 'public');

        // Simpan ke database
        SuratPernyataan::create([
            'file_surat_pernyataan' => $filename,
            'status' => 'menunggu',
            'nim' => $request->nim
        ]);

        return redirect()->route('surat.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy($id)
    {
        $surat = SuratPernyataan::findOrFail($id);

            if ($surat->file_surat_pernyataan && Storage::disk('public')->exists('surat/'.$surat->file_surat_pernyataan)) {
            Storage::disk('public')->delete('surat/'.$surat->file_surat_pernyataan);
        }


        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function show($id)
    {
        $surat = SuratPernyataan::findOrFail($id);
        $filePath = Storage::url('surat/' . $surat->file_surat_pernyataan);

        return view('surat.show', compact('filePath'));
    }

}