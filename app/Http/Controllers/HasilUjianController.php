<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjianModel;
use App\Models\JadwalModel;
use Illuminate\Support\Facades\Storage;

class HasilUjianController extends Controller
{
    /**
     * Display a listing of the hasil ujian.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all hasil ujian with their related jadwal
        $hasilUjian = HasilUjianModel::with('jadwal')->get();
        
        // Set active menu for sidebar
        $activeMenu = 'hasil_ujian';
        
        return view('hasil_ujian.index', compact('hasilUjian', 'activeMenu'));
    }

    /**
     * Show the form for creating a new hasil ujian.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all jadwal for the dropdown
        $jadwal = JadwalModel::all();
        
        // Set active menu for sidebar
        $activeMenu = 'hasil_ujian';
        
        return view('hasil_ujian.create', compact('jadwal', 'activeMenu'));
    }

    /**
     * Store a newly created hasil ujian in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tanggal' => 'required|date',
            'file_nilai' => 'required|file|mimes:pdf,doc,docx,xlsx|max:2048',
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
        ]);

        // Store the file in the storage/app/public/hasil_ujian_files directory
        $filePath = $request->file('file_nilai')->store('hasil_ujian_files', 'public');

        // Create a new hasil ujian record
        HasilUjianModel::create([
            'tanggal' => $request->tanggal,
            'file_nilai' => $filePath,
            'jadwal_id' => $request->jadwal_id,
        ]);

        // Redirect back to the index page with a success message
        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil diupload.');
    }

    /**
     * Display the specified hasil ujian.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the hasil ujian by ID
        $hasilUjian = HasilUjianModel::with('jadwal')->findOrFail($id);
        
        // Set active menu for sidebar
        $activeMenu = 'hasil_ujian';
        
        return view('hasil_ujian.show', compact('hasilUjian', 'activeMenu'));
    }

    /**
     * Show the form for editing the specified hasil ujian.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find the hasil ujian by ID
        $hasilUjian = HasilUjianModel::findOrFail($id);
        
        // Get all jadwal for the dropdown
        $jadwal = JadwalModel::all();
        
        // Set active menu for sidebar
        $activeMenu = 'hasil_ujian';
        
        return view('hasil_ujian.edit', compact('hasilUjian', 'jadwal', 'activeMenu'));
    }

    /**
     * Update the specified hasil ujian in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'tanggal' => 'required|date',
            'file_nilai' => 'nullable|file|mimes:pdf,doc,docx,xlsx|max:2048',
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
        ]);

        // Find the hasil ujian by ID
        $hasilUjian = HasilUjianModel::findOrFail($id);

        // Update the file if a new one is provided
        if ($request->hasFile('file_nilai')) {
            // Delete the old file if it exists
            if ($hasilUjian->file_nilai && Storage::disk('public')->exists($hasilUjian->file_nilai)) {
                Storage::disk('public')->delete($hasilUjian->file_nilai);
            }
            
            // Store the new file
            $filePath = $request->file('file_nilai')->store('hasil_ujian_files', 'public');
            $hasilUjian->file_nilai = $filePath;
        }

        // Update the other fields
        $hasilUjian->tanggal = $request->tanggal;
        $hasilUjian->jadwal_id = $request->jadwal_id;
        $hasilUjian->save();

        // Redirect back to the index page with a success message
        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified hasil ujian from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the hasil ujian by ID
        $hasilUjian = HasilUjianModel::findOrFail($id);

        // Delete the file if it exists
        if ($hasilUjian->file_nilai && Storage::disk('public')->exists($hasilUjian->file_nilai)) {
            Storage::disk('public')->delete($hasilUjian->file_nilai);
        }

        // Delete the record
        $hasilUjian->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil dihapus.');
    }
}
