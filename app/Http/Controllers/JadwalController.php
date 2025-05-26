<?php

namespace App\Http\Controllers;

use App\Models\JadwalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    /*================================
     =========== ADMIN ==============
     ================================*/

    public function index()
    {
        $jadwal = JadwalModel::orderBy('tanggal', 'desc')->get();
        $activeMenu = 'jadwal';

        return view('admin.jadwal.index', compact('jadwal', 'activeMenu'));
    }

    public function create()
    {
        $activeMenu = 'jadwal';
        return view('admin.jadwal.create', compact('activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'informasi' => 'required|string',
            'file_info' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only(['tanggal', 'informasi']);

        if ($request->hasFile('file_info')) {
            $data['file_info'] = $request->file('file_info')->store('jadwal', 'public');
        }

        JadwalModel::create($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalModel::findOrFail($id);
        $activeMenu = 'jadwal';

        return view('admin.jadwal.edit', compact('jadwal', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'informasi' => 'required|string',
            'file_info' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $jadwal = JadwalModel::findOrFail($id);
        $data = $request->only(['tanggal', 'informasi']);

        // Periksa apakah file baru diunggah
        if ($request->hasFile('file_info')) {
            // Hapus file lama jika ada
            if ($jadwal->file_info && Storage::disk('public')->exists($jadwal->file_info)) {
                Storage::disk('public')->delete($jadwal->file_info);
                \Log::info('File lama dihapus: ' . $jadwal->file_info);
            }

            // Simpan file baru
            $data['file_info'] = $request->file('file_info')->store('jadwal', 'public');
            \Log::info('File baru diunggah: ' . $data['file_info']);
        }

        // Perbarui data jadwal
        $jadwal->update($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalModel::findOrFail($id);

        if ($jadwal->file_info && Storage::disk('public')->exists($jadwal->file_info)) {
            Storage::disk('public')->delete($jadwal->file_info);
        }

        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function previewFile($id)
    {
        $jadwal = JadwalModel::findOrFail($id);

        // Periksa apakah file ada di database dan storage
        if (!$jadwal->file_info || !Storage::disk('public')->exists($jadwal->file_info)) {
            return redirect()->route('jadwal.index')->with('error', 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $jadwal->file_info);
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $headers = [
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ];

        // Tampilkan file berdasarkan ekstensi
        switch ($ext) {
            case 'pdf':
                return response()->file($filePath, $headers);

            case 'doc':
            case 'docx':
                return response(
                    '<p>Preview Word tidak tersedia. <a href="' . asset('storage/' . $jadwal->file_info) . '" target="_blank">Unduh file</a></p>',
                    200,
                    ['Content-Type' => 'text/html']
                );

            default:
                return redirect()->route('jadwal.index')->with('error', 'Format file tidak didukung.');
        }
    }


    /*==================================
     =========== MAHASISWA ============
     ==================================*/

    public function mahasiswaIndex()
    {
        $breadcrumb = (object) [
            'title' => 'Jadwal Kegiatan TOEIC',
            'list' => ['Home', 'Jadwal Kegiatan TOEIC']
        ];

        $page = (object) [
            'title' => 'Jadwal Kegiatan TOEIC'
        ];

        $activeMenu = 'jadwal';

        $jadwal = JadwalModel::orderBy('tanggal', 'desc')->get();

        return view('mahasiswa.jadwal.index', compact('breadcrumb', 'page', 'activeMenu', 'jadwal'));
    }

    public function mahasiswaShow($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Jadwal',
            'list' => ['Home', 'Jadwal Kegiatan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Jadwal Kegiatan TOEIC'
        ];

        $activeMenu = 'jadwal';

        $jadwal = JadwalModel::findOrFail($id);

        return view('mahasiswa.jadwal.show', compact('breadcrumb', 'page', 'activeMenu', 'jadwal'));
    }
}
