<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HasilUjianController extends Controller
{
    public function index()
    {
        // Mendapatkan data yang diperlukan untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian']
        ];

        $page = (object) [
            'title' => 'Melihat Hasil Ujian'
        ];

        $activeMenu = 'hasil-ujian';  // Menandakan menu aktif

        // Cek apakah file hasil ujian sudah diupload
        $filePath = public_path('hasil_ujian/hasil_ujian.pdf');
        $fileExists = file_exists($filePath);

        // Tentukan nilai $isAvailable dan waktu terakhir update berdasarkan keberadaan file
        $isAvailable = $fileExists;
        $fileName = $fileExists ? 'hasil_ujian.pdf' : 'Tidak ada file PDF';
        $lastUpdated = $fileExists ? date('Y-m-d H:i:s', filemtime($filePath)) : 'Belum ada update';

        // Menampilkan halaman hasil ujian
        return view('hasil_ujian.lihat_hasil', compact('breadcrumb', 'page', 'activeMenu', 'fileExists', 'isAvailable', 'fileName', 'lastUpdated'));
    }

    public function showResult()
    {
        $filePath = asset('hasil_ujian/hasil_ujian.pdf');

        $breadcrumb = (object)[
            'title' => 'Lihat Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian', 'Lihat Hasil Ujian']
        ];

        return view('hasil_ujian.result_view', compact('filePath', 'breadcrumb'));
    }

    public function download()
    {
        $filePath = public_path("hasil_ujian/hasil_ujian.pdf");

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->route('hasil_ujian.hasil.ujian')->with('error', 'File hasil ujian tidak tersedia!');
        }
    }

}
