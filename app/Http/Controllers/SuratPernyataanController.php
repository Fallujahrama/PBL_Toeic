<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPernyataanModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratPernyataanController extends Controller
{
    // Mahasiswa - View surat pernyataan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pengajuan Surat Pernyataan',
            'list' => ['Home', 'Pengajuan Surat Pernyataan']
        ];

        $page = (object) [
            'title' => 'Pengajuan Surat Pernyataan'
        ];

        $activeMenu = 'surat_pernyataan';

        // Ambil surat milik user yang sedang login
        $user = auth()->user();
        $mahasiswa = MahasiswaModel::where('nim', $user->username)->first();
        $surat = $mahasiswa ? SuratPernyataanModel::where('nim', $mahasiswa->nim)->latest()->first() : null;

        return view('mahasiswa.surat_pernyataan.index', compact('breadcrumb', 'page', 'activeMenu', 'surat', 'mahasiswa'));
    }

    // Mahasiswa - Upload surat pernyataan
    public function store(Request $request)
    {
        $request->validate([
            'file_surat_pernyataan' => 'required|mimes:pdf|max:2048',
            'nim' => 'required'
        ]);

        // Simpan file
        $file = $request->file('file_surat_pernyataan');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('surat', $filename, 'public');

        // Simpan ke database
        SuratPernyataanModel::create([
            'file_surat_pernyataan' => $filename,
            'status' => 'pending',
            'nim' => $request->nim
        ]);

        return redirect()->route('mahasiswa.surat-pernyataan.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    // Mahasiswa - Hapus surat pernyataan
    public function destroy($id)
    {
        $surat = SuratPernyataanModel::findOrFail($id);

        // Pastikan hanya mahasiswa pemilik yang bisa menghapus
        $user = auth()->user();
        if ($surat->nim !== $user->username) {
            return redirect()->route('mahasiswa.surat-pernyataan.index')->with('error', 'Anda tidak memiliki akses untuk menghapus dokumen ini.');
        }

        // Hapus file dari storage
        if ($surat->file_surat_pernyataan && Storage::disk('public')->exists('surat/' . $surat->file_surat_pernyataan)) {
            Storage::disk('public')->delete('surat/' . $surat->file_surat_pernyataan);
        }

        $surat->delete();

        return redirect()->route('mahasiswa.surat-pernyataan.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    // Admin - View semua surat pernyataan
    public function adminIndex()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Surat Pernyataan',
            'list' => ['Home', 'Kelola Surat Pernyataan']
        ];

        $page = (object) [
            'title' => 'Kelola Surat Pernyataan'
        ];

        $activeMenu = 'surat_pernyataan';

        $suratPernyataan = SuratPernyataanModel::with('mahasiswa')->latest()->get();

        return view('admin.surat_pernyataan.index', compact('breadcrumb', 'page', 'activeMenu', 'suratPernyataan'));
    }

    // Admin - View detail surat pernyataan
    public function adminShow($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Surat Pernyataan',
            'list' => ['Home', 'Kelola Surat Pernyataan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Surat Pernyataan'
        ];

        $activeMenu = 'surat_pernyataan';

        $surat = SuratPernyataanModel::with('mahasiswa')->findOrFail($id);

        return view('admin.surat_pernyataan.show', compact('breadcrumb', 'page', 'activeMenu', 'surat'));
    }

    // Admin - Validasi surat pernyataan
    public function validateSurat($id)
    {
        $surat = SuratPernyataanModel::findOrFail($id);
        $surat->update(['status' => 'valid']);

        return redirect()->route('admin.surat-pernyataan.index')->with('success', 'Surat pernyataan berhasil divalidasi.');
    }

    // Admin - Tolak surat pernyataan
    public function reject($id)
    {
        $surat = SuratPernyataanModel::findOrFail($id);
        $surat->update(['status' => 'rejected']);

        return redirect()->route('admin.surat-pernyataan.index')->with('success', 'Surat pernyataan berhasil ditolak.');
    }
}
