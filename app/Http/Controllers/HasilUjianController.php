<?php

namespace App\Http\Controllers;

use App\Models\HasilUjianModel;
use App\Models\JadwalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HasilUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasilUjian = HasilUjianModel::orderBy('tanggal', 'desc')->get();
        $activeMenu = 'hasil_ujian';

        return view('admin.hasil_ujian.index', compact('hasilUjian', 'activeMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activeMenu = 'hasil_ujian';
        $jadwal = JadwalModel::orderBy('tanggal', 'desc')->get(); // Ambil data jadwal
        return view('admin.hasil_ujian.create', compact('activeMenu', 'jadwal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
            'file_nilai' => 'required|file|mimes:pdf,doc,docx,xlsx|max:2048',
        ]);

        $data = $request->only(['tanggal', 'jadwal_id']);

        if ($request->hasFile('file_nilai')) {
            $data['file_nilai'] = $request->file('file_nilai')->store('hasil_ujian', 'public');
        }

        HasilUjianModel::create($data);

        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil diupload.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hasil_ujian = HasilUjianModel::findOrFail($id);
        $activeMenu = 'hasil_ujian';

        return view('admin.hasil_ujian.show', compact('hasil_ujian', 'activeMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hasil_ujian = HasilUjianModel::findOrFail($id);
        $activeMenu = 'hasil_ujian';
        $jadwal = JadwalModel::orderBy('tanggal', 'desc')->get(); // Add this line to get jadwal data

        return view('admin.hasil_ujian.edit', compact('hasil_ujian', 'activeMenu', 'jadwal')); // Add 'jadwal' to compact
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
            'file_nilai' => 'nullable|file|mimes:pdf,doc,docx,xlsx|max:2048',
        ]);

        $hasil_ujian = HasilUjianModel::findOrFail($id);
        $data = $request->only(['tanggal', 'jadwal_id']);

        if ($request->hasFile('file_nilai')) {
            // Delete old file if exists
            if ($hasil_ujian->file_nilai && Storage::disk('public')->exists($hasil_ujian->file_nilai)) {
                Storage::disk('public')->delete($hasil_ujian->file_nilai);
            }

            $data['file_nilai'] = $request->file('file_nilai')->store('hasil_ujian', 'public');
        }

        $hasil_ujian->update($data);

        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hasil_ujian = HasilUjianModel::findOrFail($id);

        // Delete file if exists
        if ($hasil_ujian->file_nilai && Storage::disk('public')->exists($hasil_ujian->file_nilai)) {
            Storage::disk('public')->delete($hasil_ujian->file_nilai);
        }

        $hasil_ujian->delete();

        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil dihapus.');
    }

    /**
     * Display a listing of hasil ujian for mahasiswa.
     *
     * @return \Illuminate\Http\Response
     */
    public function mahasiswaIndex()
    {
        // Mendapatkan data untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian']
        ];

        $page = (object) [
            'title' => 'Hasil Ujian TOEIC'
        ];

        $activeMenu = 'hasil_ujian';  // Menandakan menu aktif

        // Ambil semua hasil ujian yang ada (file yang diupload admin)
        $hasil_ujian = HasilUjianModel::with('jadwal')->orderBy('tanggal', 'desc')->get();


        // Menampilkan halaman index hasil ujian untuk mahasiswa
        return view('mahasiswa.hasil_ujian.index', compact('breadcrumb', 'page', 'activeMenu', 'hasil_ujian'));
    }

    /**
     * Display the specified hasil ujian for mahasiswa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mahasiswaShow($id)
    {
        // Mendapatkan data untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Detail Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Hasil Ujian TOEIC'
        ];

        $activeMenu = 'hasil_ujian';  // Menandakan menu aktif

        // Get current user's NIM
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.hasil_ujian')->with('error', 'Data mahasiswa tidak ditemukan');
        }

        // Mengambil data hasil ujian yang akan ditampilkan
        $hasil_ujian = HasilUjianModel::where('id', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        // Menampilkan halaman detail hasil ujian untuk mahasiswa
        return view('mahasiswa.hasil_ujian.show', compact('breadcrumb', 'page', 'activeMenu', 'hasil_ujian'));
    }
}
