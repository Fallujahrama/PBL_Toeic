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
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Upload lampiran sementara sebelum mengajukan surat
     */
    public function uploadTempLampiran(Request $request)
    {
        try {
            $request->validate([
                'temp_file_lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // maks 5MB
            ], [
                'temp_file_lampiran.required' => 'File lampiran harus diunggah',
                'temp_file_lampiran.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG',
                'temp_file_lampiran.max' => 'Ukuran file maksimal 5MB',
            ]);

            if ($request->hasFile('temp_file_lampiran')) {
                $file = $request->file('temp_file_lampiran');
                $filename = 'lampiran_temp_' . time() . '_' . auth()->user()->username . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('surat_pernyataan/lampiran_temp', $filename, 'public');

                // Simpan path file di session untuk digunakan saat mengajukan surat
                session(['temp_lampiran_path' => $path]);

                return response()->json([
                    'success' => true,
                    'message' => 'Berkas berhasil diunggah',
                    'path' => $path
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah berkas lampiran'
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Error uploading temp lampiran: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ajukan surat pernyataan baru
     */
    public function ajukan(Request $request)
    {
        // Cek apakah sudah ada surat pernyataan yang diajukan
        $existingSurat = SuratPernyataanModel::where('nim', auth()->user()->username)->first();

        if ($existingSurat) {
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Anda sudah pernah mengajukan surat pernyataan');
        }

        // Untuk pengajuan surat baru, periksa apakah ada lampiran di session
        if (!session()->has('temp_lampiran_path') && !$request->has('file_path')) {
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Anda harus mengunggah bukti ujian terlebih dahulu');
        }

        $filePath = $request->input('file_path') ?? session('temp_lampiran_path');

        try {
            // Buat record surat pernyataan baru
            $surat = new SuratPernyataanModel();
            $surat->nim = auth()->user()->username;
            $surat->status = 'pending';
            $surat->file_lampiran = $filePath;
            $surat->save();

            // Bersihkan session
            session()->forget('temp_lampiran_path');

            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('success', 'Surat pernyataan berhasil diajukan');
        } catch (\Exception $e) {
            \Log::error('Error saat mengajukan surat: ' . $e->getMessage());
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Terjadi kesalahan saat mengajukan surat: ' . $e->getMessage());
        }
    }

    public function generatePDF($id)
    {
        try {
            $surat = SuratPernyataanModel::with('mahasiswa')->findOrFail($id);
            $mhs = $surat->mahasiswa;

            if (!$mhs) {
                return back()->with('error', 'Data mahasiswa tidak ditemukan.');
            }

            // Generate document number
            $year = date('Y');
            $count = SuratPernyataanModel::whereYear('created_at', $year)->count();
            $documentNumber = sprintf("%03d/PL2. UPA BHS/%s", $count + 1, $year);

            $data = [
                'nama' => $mhs->nama,
                'nim' => $mhs->nim,
                'prodi' => $mhs->program_studi,
                'jurusan' => $mhs->jurusan,
                'alamat' => $mhs->alamat_saat_ini,
                'document_number' => $documentNumber,
                // Jika Anda memiliki path ttd tersimpan
                'signature_path' => public_path('img/ttd-ketua-upa.png')
            ];

            // Pastikan logo ada
            if (!file_exists(public_path('img/logo-poltek.png'))) {
                \Log::warning('Logo Politeknik tidak ditemukan di public/img/logo-poltek.png');
            }

            // Pastikan tanda tangan ada
            if (!file_exists(public_path('img/ttd-ketua-upa.png'))) {
                \Log::warning('File tanda tangan tidak ditemukan di public/img/ttd-ketua-upa.png');
                $data['signature_path'] = null; // Jika tidak ada, kosongkan saja
            }

            // Generate PDF (make sure you're using the correct view path)
            $pdf = PDF::loadView('mahasiswa.surat_pernyataan.surat_pernyataan_toeic', compact('data'));
            $filename = 'surat_toeic_' . $mhs->nim . '_' . now()->timestamp . '.pdf';
            $path = "surat/$filename";

            Storage::put("public/$path", $pdf->output());

            // Update surat record with the generated file
            $surat->file_surat_pernyataan = $filename;
            $surat->save();

            return back()->with('success', 'Dokumen surat keterangan TOEIC berhasil dibuat.');
        } catch (\Exception $e) {
            \Log::error('Error saat membuat dokumen surat keterangan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat dokumen surat keterangan: ' . $e->getMessage());
        }
    }

    function previewSurat($id)
    {
        try {
            \Log::info("Previewing surat with ID: " . $id);

            // Cari surat pernyataan berdasarkan ID
            $surat = SuratPernyataanModel::findOrFail($id);
            \Log::info("Surat found: " . json_encode($surat->toArray()));

            // Dapatkan data user yang sedang login
            $user = Auth::user();
            \Log::info("User info: " . json_encode([
                'username' => $user->username,
                'nim' => $user->nim ?? 'null', // jika properti nim ada
                'role' => $user->role ?? 'unknown'
            ]));

            // Untuk admin, bypass pengecekan NIM
            if ($user->role === 'admin' || $user->role === 'Admin') {
                // Admin dapat mengakses semua surat
                \Log::info("Admin access granted");
            }
            // Untuk mahasiswa, periksa kecocokan NIM
            else {
                // Periksa apakah user memiliki nim yang sama dengan surat
                // Pastikan cara mendapatkan NIM yang benar (mungkin $user->username atau $user->nim)
                $userNim = $user->nim ?? $user->username;
                \Log::info("Comparing user NIM: {$userNim} with surat NIM: {$surat->nim}");

                if ($userNim != $surat->nim) {
                    \Log::warning("Unauthorized access attempt: User {$userNim} tried to access document for {$surat->nim}");
                    return redirect()->back()->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
                }
            }

            // Pastikan surat sudah valid dan memiliki file
            if ($surat->status != 'valid' || !$surat->file_surat_pernyataan) {
                \Log::warning("Invalid document status or missing file: status={$surat->status}, file={$surat->file_surat_pernyataan}");
                return redirect()->back()->with('error', 'Dokumen belum divalidasi atau tidak ditemukan.');
            }

            // Path ke file PDF
            $filePath = storage_path('app/public/surat/' . $surat->file_surat_pernyataan);
            \Log::info("File path: {$filePath}");

            // Cek apakah file ada
            if (!file_exists($filePath)) {
                \Log::error("File not found: {$filePath}");
                return redirect()->back()->with('error', 'File surat tidak ditemukan.');
            }

            \Log::info("Serving preview for file: {$filePath}");

            // Tampilkan PDF di browser
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Surat_Keterangan_TOEIC_' . $surat->nim . '.pdf"',
            ]);

        } catch (\Exception $e) {
            \Log::error('Error saat preview surat: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuka dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Upload file lampiran bukti ujian TOEIC 2x
     */
    public function uploadLampiran(Request $request, $id)
    {
        $request->validate([
            'file_lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // maks 5MB
        ], [
            'file_lampiran.required' => 'File lampiran harus diunggah',
            'file_lampiran.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG',
            'file_lampiran.max' => 'Ukuran file maksimal 5MB',
        ]);

        $surat = SuratPernyataanModel::find($id);

        if (!$surat) {
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Surat pernyataan tidak ditemukan');
        }

        // Cek apakah pengguna adalah pemilik surat
        if ($surat->nim !== auth()->user()->username) {
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengunggah lampiran ini');
        }

        // Cek jika surat sudah divalidasi, maka lampiran tidak boleh diubah
        if ($surat->status === 'valid') {
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Lampiran tidak dapat diubah karena surat pernyataan sudah divalidasi');
        }

        // Upload file
        if ($request->hasFile('file_lampiran')) {
            // Hapus file lama jika ada
            if ($surat->file_lampiran && Storage::exists('public/' . $surat->file_lampiran)) {
                Storage::delete('public/' . $surat->file_lampiran);
            }

            $file = $request->file('file_lampiran');
            $filename = 'lampiran_' . time() . '_' . $surat->nim . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('surat_pernyataan/lampiran', $filename, 'public');

            $surat->file_lampiran = $path;
            $surat->save();

            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('success', 'Berkas lampiran berhasil diunggah');
        }

        return redirect()->route('mahasiswa.surat-pernyataan.index')
            ->with('error', 'Gagal mengunggah berkas lampiran');
    }

    /**
     * Preview file lampiran untuk mahasiswa
     */
    public function previewLampiran($id)
    {
        try {
            \Log::info("Mahasiswa preview lampiran with ID: {$id}");

            $surat = SuratPernyataanModel::find($id);

            if (!$surat || !$surat->file_lampiran) {
                \Log::warning("File lampiran tidak ditemukan, ID: {$id}");
                abort(404, 'File lampiran tidak ditemukan');
            }

            // Cek apakah pengguna adalah pemilik surat
            if ($surat->nim !== auth()->user()->username) {
                \Log::warning("Akses ditolak: User " . auth()->user()->username . " mencoba mengakses lampiran milik {$surat->nim}");
                abort(403, 'Anda tidak memiliki akses');
            }

            $path = storage_path('app/public/' . $surat->file_lampiran);

            if (!file_exists($path)) {
                \Log::warning("File fisik tidak ditemukan: {$path}");
                abort(404, 'File lampiran tidak ditemukan');
            }

            \Log::info("Serving file untuk mahasiswa: {$path}");
            return $this->serveFile($path);

        } catch (\Exception $e) {
            \Log::error("Error pada preview lampiran mahasiswa: " . $e->getMessage());
            \Log::error($e->getTraceAsString());
            abort(500, 'Terjadi kesalahan server');
        }
    }

    /**
     * Preview file lampiran untuk admin
     */
    public function previewLampiranAdmin($id)
    {
        try {
            \Log::info("Admin preview lampiran with ID: {$id}");

            $surat = SuratPernyataanModel::find($id);

            if (!$surat || !$surat->file_lampiran) {
                \Log::warning("File lampiran tidak ditemukan, ID: {$id}");
                abort(404, 'File lampiran tidak ditemukan');
            }

            $path = storage_path('app/public/' . $surat->file_lampiran);

            if (!file_exists($path)) {
                \Log::warning("File fisik tidak ditemukan: {$path}");
                abort(404, 'File lampiran tidak ditemukan');
            }

            \Log::info("Serving file untuk admin: {$path}");
            return $this->serveFile($path);

        } catch (\Exception $e) {
            \Log::error("Error pada preview lampiran admin: " . $e->getMessage());
            \Log::error($e->getTraceAsString());
            abort(500, 'Terjadi kesalahan server');
        }
    }

    /**
     * Helper method untuk menampilkan file
     */
    private function serveFile($path)
    {
        $fileExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
            return response()->file($path);
        } elseif ($fileExtension == 'pdf') {
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="lampiran_surat_pernyataan.pdf"'
            ]);
        } else {
            abort(404, 'Format file tidak didukung');
        }
    }

    /**
     * Download file lampiran untuk mahasiswa
     */
    public function downloadLampiran($id)
    {
        try {
            $surat = SuratPernyataanModel::find($id);

            if (!$surat || !$surat->file_lampiran) {
                return back()->with('error', 'File lampiran tidak ditemukan');
            }

            // Cek apakah pengguna adalah pemilik surat
            if ($surat->nim !== auth()->user()->username) {
                return back()->with('error', 'Anda tidak memiliki akses untuk mengunduh file ini');
            }

            $path = storage_path('app/public/' . $surat->file_lampiran);

            if (!file_exists($path)) {
                return back()->with('error', 'File lampiran tidak ditemukan');
            }

            $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
            $fileName = "lampiran_bukti_ujian_{$surat->nim}.{$fileExtension}";

            return response()->download($path, $fileName);
        } catch (\Exception $e) {
            \Log::error("Error pada download lampiran: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }

    /**
     * Download file lampiran untuk admin
     */
    public function downloadLampiranAdmin($id)
    {
        try {
            $surat = SuratPernyataanModel::find($id);

            if (!$surat || !$surat->file_lampiran) {
                return back()->with('error', 'File lampiran tidak ditemukan');
            }

            $path = storage_path('app/public/' . $surat->file_lampiran);

            if (!file_exists($path)) {
                return back()->with('error', 'File lampiran tidak ditemukan');
            }

            $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
            $fileName = "lampiran_bukti_ujian_{$surat->nim}.{$fileExtension}";

            return response()->download($path, $fileName);
        } catch (\Exception $e) {
            \Log::error("Error pada download lampiran admin: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }

    /**
     * Hapus lampiran surat pernyataan
     */
    public function hapusLampiran($id)
    {
        try {
            $surat = SuratPernyataanModel::findOrFail($id);

            // Validasi apakah pengguna adalah pemilik surat
            if ($surat->nim !== auth()->user()->username) {
                return redirect()->route('mahasiswa.surat-pernyataan.index')
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus lampiran ini');
            }

            // Cek jika surat sudah divalidasi, maka lampiran tidak boleh dihapus
            if ($surat->status === 'valid') {
                return redirect()->route('mahasiswa.surat-pernyataan.index')
                    ->with('error', 'Lampiran tidak dapat dihapus karena surat pernyataan sudah divalidasi');
            }

            // Hapus file dari storage jika ada
            if ($surat->file_lampiran && Storage::exists('public/' . $surat->file_lampiran)) {
                Storage::delete('public/' . $surat->file_lampiran);
            }

            // Update record di database
            $surat->file_lampiran = null;
            $surat->save();

            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('success', 'Berkas lampiran berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error menghapus lampiran: ' . $e->getMessage());
            return redirect()->route('mahasiswa.surat-pernyataan.index')
                ->with('error', 'Terjadi kesalahan saat menghapus lampiran');
        }
    }
}
