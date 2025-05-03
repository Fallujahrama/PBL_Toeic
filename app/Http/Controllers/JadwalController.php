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
                'informasi' => 'Ujian TOEIC Sesi 1 - Listening & Reading',
                'file_info' => 'file1.pdf'
            ],
            (object) [
                'id_jadwal' => 2,
                'tanggal' => '2025-05-12',
                'informasi' => 'Ujian TOEIC Sesi 2 - Speaking & Writing',
                'file_info' => 'file2.pdf'
            ],
            (object) [
                'id_jadwal' => 3,
                'tanggal' => '2025-05-15',
                'informasi' => 'Ujian TOEIC Sesi 3 - Full Test',
                'file_info' => 'file3.pdf'
            ],
        ];
    
        // Tambahkan breadcrumb
        $breadcrumb = (object)[
            'title' => 'Jadwal Ujian TOEIC',
            'list' => ['Home', 'Jadwal']
        ];
    
        return view('jadwal.jadwal', compact('jadwal', 'breadcrumb'));
    }
    
}