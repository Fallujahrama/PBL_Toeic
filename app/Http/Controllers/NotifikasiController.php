<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /*==========================
     ========== ADMIN ==========
     ==========================*/

    // Menampilkan daftar notifikasi (admin)
    public function index()
    {
        $notifications = NotifikasiModel::orderBy('tanggal', 'desc')->get();
        $activeMenu = 'notifikasi';

        return view('admin.notifications.index', compact('notifications', 'activeMenu'));
    }

    // Menampilkan detail notifikasi (admin)
    public function show($id)
    {
        $notification = NotifikasiModel::findOrFail($id);
        $activeMenu = 'notifikasi';

        return view('admin.notifications.show', compact('notification', 'activeMenu'));
    }

    // Form tambah notifikasi (admin)
    public function create()
    {
        $activeMenu = 'notifikasi';
        return view('admin.notifications.create', compact('activeMenu'));
    }

    // Simpan notifikasi baru (admin)
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string',
        ]);

        NotifikasiModel::create($request->all());

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    // Form edit notifikasi (admin)
    public function edit($id)
    {
        $notification = NotifikasiModel::findOrFail($id);
        $activeMenu = 'notifikasi';

        return view('admin.notifications.edit', compact('notification', 'activeMenu'));
    }

    // Update notifikasi (admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string',
        ]);

        $notification = NotifikasiModel::findOrFail($id);
        $notification->update($request->all());

        return redirect()->route('notifications.index')->with('success', 'Notifikasi berhasil diperbarui.');
    }

    // Hapus notifikasi (admin)
    public function destroy($id)
    {
        $notification = NotifikasiModel::findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notifikasi berhasil dihapus.');
    }


    /*==============================
     ========== MAHASISWA ==========
     ==============================*/

    // Menampilkan daftar notifikasi untuk mahasiswa
    public function mahasiswaIndex()
    {
        $breadcrumb = (object) [
            'title' => 'Notifikasi',
            'list' => ['Home', 'Notifikasi']
        ];

        $page = (object) [
            'title' => 'Notifikasi'
        ];

        $activeMenu = 'notifikasi';
        $user = Auth::user();

        $notifikasi = NotifikasiModel::orderBy('created_at', 'desc')->get();

        return view('mahasiswa.notifikasi.index', compact('breadcrumb', 'page', 'activeMenu', 'notifikasi'));
    }

    // Menampilkan detail notifikasi untuk mahasiswa
    public function mahasiswaShow($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Notifikasi',
            'list' => ['Home', 'Notifikasi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Notifikasi'
        ];

        $activeMenu = 'notifikasi';
        $user = Auth::user();

        $notifikasi = NotifikasiModel::where('id', $id)->firstOrFail();

        return view('mahasiswa.notifikasi.show', compact('breadcrumb', 'page', 'activeMenu', 'notifikasi'));
    }

    // Menandai notifikasi sebagai dibaca (AJAX)
    public function markAsRead($id)
    {
        $notifikasi = NotifikasiModel::where('id', $id)->firstOrFail();
        return response()->json(['success' => true]);
    }
}
