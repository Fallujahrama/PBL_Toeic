<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    // Menampilkan daftar pendaftar
    public function index()
{
    $breadcrumb = [
        'title' => 'Verifikasi Pendaftaran',
        'list' => ['Home', 'Verifikasi']
    ];

    return view('admin.verifikasi', [
        'breadcrumb' => $breadcrumb,
        'pendaftarans' => Pendaftaran::all()
    ]);
}

public function show($id)
{
    $breadcrumb = [
        'title' => 'Detail Pendaftar',
        'list' => ['Home', 'Verifikasi', 'Detail']
    ];

    $pendaftaran = Pendaftaran::with('mahasiswa')->findOrFail($id);
    
    return view('admin.detail', [
        'breadcrumb' => $breadcrumb,
        'pendaftaran' => $pendaftaran
    ]);
}

public function verify(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected,pending'
    ]);

    $pendaftaran = Pendaftaran::findOrFail($id);
    $pendaftaran->status_verifikasi = $request->status;
    $pendaftaran->save();

    return redirect()->route('admin.verifikasi')
        ->with('success', 'Status pendaftaran berhasil diperbarui');
}
}