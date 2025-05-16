<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Mahasiswa',
            'list' => ['Home', 'Data Mahasiswa']
        ];

        $activeMenu = 'mahasiswa';

        // Ambil filter kampus dari request
        $kampusFilter = request('kampus');

        // Ambil data mahasiswa sesuai filter kampus
        $data = Mahasiswa::select('nim', 'nama', 'jurusan', 'program_studi', 'kampus', 'no_whatsapp')
            ->when($kampusFilter, function ($query, $kampusFilter) {
                return $query->where('kampus', $kampusFilter);
            })
            ->get();

        // Ambil daftar kampus unik untuk filter dropdown
        $kampus = Mahasiswa::select('kampus')->distinct()->get();

        return view('data_mahasiswa.index', compact('breadcrumb', 'activeMenu', 'data', 'kampus', 'kampusFilter'));
    }

}
