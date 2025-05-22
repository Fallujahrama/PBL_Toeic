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

        if ($request->hasFile('file_info')) {
            if ($jadwal->file_info && Storage::disk('public')->exists($jadwal->file_info)) {
                Storage::disk('public')->delete($jadwal->file_info);
            }
            $data['file_info'] = $request->file('file_info')->store('jadwal', 'public');
        }

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

        if (!$jadwal->file_info || !Storage::disk('public')->exists($jadwal->file_info)) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $jadwal->file_info);
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        $headers = [
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ];

        if ($ext === 'pdf') {
            return response()->file($filePath, $headers);
        } elseif (in_array($ext, ['doc', 'docx'])) {
            return response(
                '<p>Preview Word tidak tersedia. <a href="' . asset('storage/' . $jadwal->file_info) . '" target="_blank">Unduh file</a></p>',
                200,
                ['Content-Type' => 'text/html']
            );
        }

        return abort(415, 'Format file tidak didukung.');
    }


    /*==================================
     =========== MAHASISWA ============
     ==================================*/

    public function mahasiswaIndex()
    {
        $breadcrumb = (object) [
            'title' => 'Jadwal Ujian',
            'list' => ['Home', 'Jadwal Ujian']
        ];

        $page = (object) [
            'title' => 'Jadwal Ujian TOEIC'
        ];

        $activeMenu = 'jadwal';

        $jadwal = JadwalModel::orderBy('tanggal', 'desc')->get();

        return view('mahasiswa.jadwal.index', compact('breadcrumb', 'page', 'activeMenu', 'jadwal'));
    }

    public function mahasiswaShow($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Jadwal',
            'list' => ['Home', 'Jadwal Ujian', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Jadwal Ujian TOEIC'
        ];

        $activeMenu = 'jadwal';

        $jadwal = JadwalModel::findOrFail($id);

        return view('mahasiswa.jadwal.show', compact('breadcrumb', 'page', 'activeMenu', 'jadwal'));
    }
}
