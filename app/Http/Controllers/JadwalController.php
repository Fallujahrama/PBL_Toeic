<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        // Data dummy untuk ujian TOEIC
        $jadwal = [
            (object) [
                'id_jadwal' => 1,
                'tanggal' => '2025-05-10',
                'nama' => 'Alex',
                'informasi' => 'Ujian TOEIC Sesi 1',
                'file_info' => 'file1.pdf'
            ],
            (object) [
                'id_jadwal' => 2,
                'tanggal' => '2025-05-10',
                'nama' => 'Putra',
                'informasi' => 'Ujian TOEIC Sesi 2',
                'file_info' => 'file2.pdf'
            ],
            (object) [
                'id_jadwal' => 3,
                'tanggal' => '2025-05-12',
                'nama' => 'Haikal',
                'informasi' => 'Ujian TOEIC Sesi 2',
                'file_info' => 'file3.pdf'
            ],
        ];

        // Tambahkan breadcrumb
        $breadcrumb = (object)[
            'title' => 'Jadwal Ujian TOEIC',
            'list' => ['Home', 'Jadwal']
        ];

        // Kirim data ke view
        return view('jadwal.jadwal', compact('jadwal', 'breadcrumb'));
    }

    public function show($id)
    {
        // Cari data berdasarkan ID
        $jadwal = collect([
            (object) ['id_jadwal' => 1, 'tanggal' => '2025-05-10', 'nama' => 'Alex', 'informasi' => 'Ujian TOEIC Sesi 1', 'file_info' => 'file1.pdf'],
            (object) ['id_jadwal' => 2, 'tanggal' => '2025-05-10', 'nama' => 'Putra', 'informasi' => 'Ujian TOEIC Sesi 2', 'file_info' => 'file2.pdf'],
            (object) ['id_jadwal' => 3, 'tanggal' => '2025-05-12', 'nama' => 'Haikal', 'informasi' => 'Ujian TOEIC Sesi 2', 'file_info' => 'file3.pdf'],
        ])->firstWhere('id_jadwal', $id);

        // Tambahkan breadcrumb untuk halaman detail
        $breadcrumb = (object)[
            'title' => 'Detail Jadwal',
            'list' => ['Home', 'Jadwal', 'Detail']
        ];

        return view('jadwal.detail', compact('jadwal', 'breadcrumb'));
    }

    public function edit($id)
    {
        // Cari data berdasarkan ID
        $jadwal = collect([
            (object) ['id_jadwal' => 1, 'tanggal' => '2025-05-10', 'nama' => 'Alex', 'informasi' => 'Ujian TOEIC Sesi 1', 'file_info' => 'file1.pdf'],
            (object) ['id_jadwal' => 2, 'tanggal' => '2025-05-10', 'nama' => 'Putra', 'informasi' => 'Ujian TOEIC Sesi 2', 'file_info' => 'file2.pdf'],
            (object) ['id_jadwal' => 3, 'tanggal' => '2025-05-12', 'nama' => 'Haikal', 'informasi' => 'Ujian TOEIC Sesi 2', 'file_info' => 'file3.pdf'],
        ])->firstWhere('id_jadwal', $id);

        // Tambahkan breadcrumb untuk halaman edit
        $breadcrumb = (object)[
            'title' => 'Edit Jadwal',
            'list' => ['Home', 'Jadwal', 'Edit']
        ];

        return view('jadwal.edit', compact('jadwal', 'breadcrumb'));
    }

    public function destroy($id)
    {
        // Logika untuk menghapus data
        return redirect()->route('jadwal.index')->with('success', 'Data berhasil dihapus!');
    }
}