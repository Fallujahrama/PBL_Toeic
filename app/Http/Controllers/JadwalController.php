<?php

namespace App\Http\Controllers;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
   public function index()
{
    // Ambil semua jadwal dari database
    $jadwal = Jadwal::all();

    $breadcrumb = (object)[
        'title' => 'Jadwal Ujian TOEIC',
        'list' => ['Home', 'Jadwal']
    ];

    return view('jadwal.jadwal', compact('jadwal', 'breadcrumb'));
}

public function jadwalMahasiswa()
{
    // Contoh: filter berdasarkan mahasiswa yang login (misal, NIM atau user_id)
    // Untuk sementara, tampilkan semua jadwal
    $jadwalMahasiswa = Jadwal::all();

    $breadcrumb = (object)[
        'title' => 'Jadwal Saya',
        'list' => ['Home', 'Jadwal Saya']
    ];

    return view('mahasiswa.jadwal', compact('jadwalMahasiswa', 'breadcrumb'));
}
}