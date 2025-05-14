<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifikasiModel;

class NotifikasiController extends Controller
{
    // Menampilkan daftar notifikasi
    public function index()
    {
        $notifications = NotifikasiModel::all();
        return view('notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = NotifikasiModel::findOrFail($id);
        return view('notifications.show', compact('notification'));
    }

    // Menampilkan form untuk membuat notifikasi baru
    public function create()
    {
        return view('notifications.create');
    }

    // Menyimpan notifikasi baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string',
        ]);

        NotifikasiModel::create($request->all());

        return redirect()->route('notifications.index')->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit notifikasi
    public function edit($id)
    {
        $notification = NotifikasiModel::findOrFail($id);
        return view('notifications.edit', compact('notification'));
    }

    // Memperbarui notifikasi
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

    // Menghapus notifikasi
    public function destroy($id)
    {
        $notification = NotifikasiModel::findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notifikasi berhasil dihapus.');
    }
}