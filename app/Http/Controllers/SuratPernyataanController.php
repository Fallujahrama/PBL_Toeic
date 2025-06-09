<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPernyataanModel;
use App\Models\TemplateSuratModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

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
        $activeTemplate = TemplateSuratModel::where('status', 'aktif')->latest()->first();

        return view('mahasiswa.surat_pernyataan.index', compact('breadcrumb', 'page', 'activeMenu', 'surat', 'mahasiswa', 'activeTemplate'));
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
        $page = (object) [
            'title' => 'Kelola Surat Pernyataan'
        ];

        $activeMenu = 'surat-pernyataan';
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['title' => 'Kelola Surat Pernyataan', 'url' => '#']
        ];

        // Get templates and surat pernyataan
        $templates = TemplateSuratModel::orderBy('created_at', 'desc')->get();
        $suratPernyataan = SuratPernyataanModel::with('mahasiswa')->get();

        return view('admin.surat_pernyataan.index', compact('page', 'activeMenu', 'breadcrumb', 'templates', 'suratPernyataan'));
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

    public function uploadTemplate(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'file_template' => 'required|mimes:pdf|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            \DB::beginTransaction();

            // Upload file
            $file = $request->file('file_template');
            $filename = time() . '_template_' . $file->getClientOriginalName();

            // Simpan file ke storage
            $path = $file->storeAs('templates', $filename, 'public');

            // Debug log
            \Log::info('File uploaded successfully to: ' . $path);

            // Simpan ke database sesuai struktur tabel
            $template = new TemplateSuratModel();
            $template->nama_template = $request->nama_template;
            $template->file_template = $filename;
            $template->deskripsi = $request->deskripsi;
            $template->status = 'aktif'; // Sesuai enum di database

            if(!$template->save()) {
                throw new \Exception('Failed to save template to database');
            }

            \DB::commit();

            return redirect()
                ->route('admin.surat-pernyataan.index')
                ->with('success', 'Template surat berhasil diunggah.');

        } catch (\Exception $e) {
            \DB::rollBack();
            // Hapus file jika gagal simpan ke database
            if(isset($filename)) {
                Storage::disk('public')->delete('templates/' . $filename);
            }

            \Log::error('Error uploading template: ' . $e->getMessage());
            return redirect()
                ->route('admin.surat-pernyataan.index')
                ->with('error', 'Gagal mengunggah template: ' . $e->getMessage());
        }
    }

    // Sesuaikan juga method toggleStatus
    public function toggleStatus($id)
    {
        $template = TemplateSuratModel::findOrFail($id);
        $template->status = $template->status === 'aktif' ? 'nonaktif' : 'aktif';
        $template->save();

        $message = $template->status === 'aktif' ? 'Template berhasil diaktifkan.' : 'Template berhasil dinonaktifkan.';
        return redirect()->route('admin.surat-pernyataan.index')->with('success', $message);
    }

    public function downloadAll()
    {
        \Log::info('Accessing downloadAll method');
        try {
            $documents = SuratPernyataanModel::with('mahasiswa')->get();
            \Log::info('Documents count: ' . $documents->count());

            if ($documents->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada dokumen untuk diunduh');
            }

            $zipName = 'surat-pernyataan-' . now()->format('Y-m-d-His') . '.zip';
            $zipPath = storage_path('app/public/temp/' . $zipName);

            \Log::info('Creating zip at: ' . $zipPath);

            if (!File::exists(dirname($zipPath))) {
                File::makeDirectory(dirname($zipPath), 0755, true);
            }

            $zip = new \ZipArchive();
            $res = $zip->open($zipPath, \ZipArchive::CREATE);

            if ($res !== TRUE) {
                \Log::error('Failed to create zip: ' . $res);
                return redirect()->back()->with('error', 'Gagal membuat file zip');
            }

            foreach ($documents as $doc) {
                $filePath = storage_path('app/public/surat/' . $doc->file_surat_pernyataan);
                \Log::info('Adding file: ' . $filePath);

                if (File::exists($filePath)) {
                    $zip->addFile($filePath, $doc->nim . '_' . $doc->created_at->format('Y-m-d') . '.pdf');
                }
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Error in downloadAll: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }

    public function deleteTemplate($id)
    {
        $template = \App\Models\TemplateSuratModel::findOrFail($id);

        // Hapus file dari storage
        if ($template->file_template && \Storage::disk('public')->exists('templates/' . $template->file_template)) {
            \Storage::disk('public')->delete('templates/' . $template->file_template);
        }

        $template->delete();

        return redirect()->route('admin.surat-pernyataan.index')->with('success', 'Template surat berhasil dihapus.');
    }
}
