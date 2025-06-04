<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan data untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Data Mahasiswa',
            'list' => ['Home', 'Data Mahasiswa']
        ];

        $page = (object) [
            'title' => 'Daftar Mahasiswa'
        ];

        $activeMenu = 'mahasiswa';  // Menandakan menu aktif

        // Ambil filter kampus dari request
        $kampusFilter = request('kampus');

        // Mengambil data mahasiswa dengan filter kampus jika ada
        $data = MahasiswaModel::select('nim', 'nama', 'nik', 'jurusan', 'program_studi', 'kampus', 'no_whatsapp')
            ->when($kampusFilter, function ($query, $kampusFilter) {
                return $query->where('kampus', $kampusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil daftar kampus unik untuk filter dropdown
        $kampus = MahasiswaModel::select('kampus')->distinct()->get();

        // Menampilkan halaman index mahasiswa
        return view('data_mahasiswa.index', compact('breadcrumb', 'page', 'activeMenu', 'data', 'kampus', 'kampusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($nim)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Mahasiswa',
            'list' => ['Home', 'Data Mahasiswa', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Data Mahasiswa'
        ];

        $activeMenu = 'mahasiswa';

        $data = MahasiswaModel::where('nim', $nim)->firstOrFail();

        return view('data_mahasiswa.show', compact('breadcrumb', 'page', 'activeMenu', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nim)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Mahasiswa',
            'list' => ['Home', 'Data Mahasiswa', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Mahasiswa'
        ];

        $activeMenu = 'mahasiswa';

        $data = MahasiswaModel::where('nim', $nim)->firstOrFail();

        return view('data_mahasiswa.edit', compact('breadcrumb', 'page', 'activeMenu', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nim)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'kampus' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:15',
            'alamat_asal' => 'required|string',
            'alamat_saat_ini' => 'required|string',
            'nik' => 'required|string|max:16',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mahasiswa = MahasiswaModel::where('nim', $nim)->firstOrFail();
        $mahasiswa->update($request->all());

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nim)
    {
        $mahasiswa = MahasiswaModel::where('nim', $nim)->firstOrFail();
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
