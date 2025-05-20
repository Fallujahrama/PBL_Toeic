<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of registrations for verification.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all registrations with their related student data
        $pendaftarans = PendaftaranModel::with('mahasiswa')->get();
        
        // Set active menu for sidebar
        $activeMenu = 'verifikasi';
        
        // Data for breadcrumb
        $breadcrumb = (object) [
            'title' => 'Verifikasi Pendaftaran',
            'list' => ['Home', 'Verifikasi']
        ];

        $page = (object) [
            'title' => 'Verifikasi Pendaftaran TOEIC'
        ];
        
        return view('verifikasi.index', compact('pendaftarans', 'activeMenu', 'breadcrumb', 'page'));
    }

    /**
     * Show the form for creating a new verification record.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all students who don't have a registration record yet
        $mahasiswas = MahasiswaModel::whereDoesntHave('pendaftaran')->get();
        
        // Set active menu for sidebar
        $activeMenu = 'verifikasi';
        
        // Data for breadcrumb
        $breadcrumb = (object) [
            'title' => 'Tambah Pendaftaran',
            'list' => ['Home', 'Verifikasi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Pendaftaran TOEIC'
        ];
        
        return view('verifikasi.create', compact('mahasiswas', 'activeMenu', 'breadcrumb', 'page'));
    }

    /**
     * Store a newly created verification record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'status_verifikasi' => 'required|in:approved,rejected,pending',
            'keterangan' => 'nullable|string',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Store files if uploaded
        $fileKtp = $request->hasFile('file_ktp') ? $request->file('file_ktp')->store('ktp') : null;
        $fileKtm = $request->hasFile('file_ktm') ? $request->file('file_ktm')->store('scan_ktm') : null;
        $fileFoto = $request->hasFile('file_foto') ? $request->file('file_foto')->store('pas_foto') : null;

        // Create new registration record
        PendaftaranModel::create([
            'nim' => $request->nim,
            'status_verifikasi' => $request->status_verifikasi,
            'keterangan' => $request->keterangan,
            'file_ktp' => $fileKtp,
            'file_ktm' => $fileKtm,
            'file_foto' => $fileFoto,
        ]);

        // Redirect to verification list with success message
        return redirect()->route('verifikasi.index')
            ->with('success', 'Pendaftaran berhasil ditambahkan');
    }

    /**
     * Display the specified registration for verification.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the registration by ID with its related student data
        $pendaftaran = PendaftaranModel::with('mahasiswa')->where('id_pendaftaran', $id)->firstOrFail();
        
        // Set active menu for sidebar
        $activeMenu = 'verifikasi';
        
        // Data for breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail Pendaftaran',
            'list' => ['Home', 'Verifikasi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Pendaftaran TOEIC'
        ];
        
        return view('verifikasi.show', compact('pendaftaran', 'activeMenu', 'breadcrumb', 'page'));
    }

    /**
     * Show the form for editing the specified verification record.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find the registration by ID with its related student data
        $pendaftaran = PendaftaranModel::with('mahasiswa')->where('id_pendaftaran', $id)->firstOrFail();
        
        // Set active menu for sidebar
        $activeMenu = 'verifikasi';
        
        // Data for breadcrumb
        $breadcrumb = (object) [
            'title' => 'Edit Pendaftaran',
            'list' => ['Home', 'Verifikasi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Pendaftaran TOEIC'
        ];
        
        return view('verifikasi.edit', compact('pendaftaran', 'activeMenu', 'breadcrumb', 'page'));
    }

    /**
     * Update the specified verification record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status_verifikasi' => 'required|in:approved,rejected,pending',
            'keterangan' => 'nullable|string',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Find the registration by ID
        $pendaftaran = PendaftaranModel::where('id_pendaftaran', $id)->firstOrFail();
        
        // Update files if uploaded
        if ($request->hasFile('file_ktp')) {
            // Delete old file if exists
            if ($pendaftaran->file_ktp && Storage::exists($pendaftaran->file_ktp)) {
                Storage::delete($pendaftaran->file_ktp);
            }
            $pendaftaran->file_ktp = $request->file('file_ktp')->store('ktp');
        }
        
        if ($request->hasFile('file_ktm')) {
            // Delete old file if exists
            if ($pendaftaran->file_ktm && Storage::exists($pendaftaran->file_ktm)) {
                Storage::delete($pendaftaran->file_ktm);
            }
            $pendaftaran->file_ktm = $request->file('file_ktm')->store('scan_ktm');
        }
        
        if ($request->hasFile('file_foto')) {
            // Delete old file if exists
            if ($pendaftaran->file_foto && Storage::exists($pendaftaran->file_foto)) {
                Storage::delete($pendaftaran->file_foto);
            }
            $pendaftaran->file_foto = $request->file('file_foto')->store('pas_foto');
        }
        
        // Update other fields using direct DB update to ensure we use the correct primary key
        DB::table('pendaftaran')
            ->where('id_pendaftaran', $id)
            ->update([
                'status_verifikasi' => $request->status_verifikasi,
                'keterangan' => $request->keterangan,
                'file_ktp' => $pendaftaran->file_ktp,
                'file_ktm' => $pendaftaran->file_ktm,
                'file_foto' => $pendaftaran->file_foto,
                'updated_at' => now()
            ]);

        // Redirect to verification list with success message
        return redirect()->route('verifikasi.index')
            ->with('success', 'Pendaftaran berhasil diperbarui');
    }

    /**
     * Update the verification status of a registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        // Update directly using DB facade to ensure we use the correct primary key
        DB::table('pendaftaran')
            ->where('id_pendaftaran', $id)
            ->update([
                'status_verifikasi' => $request->status,
                'keterangan' => $request->keterangan,
                'updated_at' => now()
            ]);

        // Redirect back to the verification list with a success message
        return redirect()->route('verifikasi.index')
            ->with('success', 'Status pendaftaran berhasil diperbarui');
    }
    
    /**
     * Remove the specified verification record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the registration by ID
        $pendaftaran = PendaftaranModel::where('id_pendaftaran', $id)->firstOrFail();
        
        // Delete files if they exist
        if ($pendaftaran->file_ktp && Storage::exists($pendaftaran->file_ktp)) {
            Storage::delete($pendaftaran->file_ktp);
        }
        
        if ($pendaftaran->file_ktm && Storage::exists($pendaftaran->file_ktm)) {
            Storage::delete($pendaftaran->file_ktm);
        }
        
        if ($pendaftaran->file_foto && Storage::exists($pendaftaran->file_foto)) {
            Storage::delete($pendaftaran->file_foto);
        }
        
        // Delete the registration record using DB facade to ensure we use the correct primary key
        DB::table('pendaftaran')->where('id_pendaftaran', $id)->delete();
        
        // Redirect to verification list with success message
        return redirect()->route('verifikasi.index')
            ->with('success', 'Pendaftaran berhasil dihapus');
    }

    /**
     * Download the specified file from a registration.
     *
     * @param  int  $id
     * @param  string  $type
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile($id, $type)
    {
        $pendaftaran = PendaftaranModel::where('id_pendaftaran', $id)->firstOrFail();
        
        $fileColumn = '';
        switch ($type) {
            case 'ktp':
                $fileColumn = 'file_ktp';
                break;
            case 'ktm':
                $fileColumn = 'file_ktm';
                break;
            case 'foto':
                $fileColumn = 'file_foto';
                break;
            default:
                abort(404, 'File tidak ditemukan');
        }
        
        if (!$pendaftaran->$fileColumn) {
            abort(404, 'File tidak ditemukan');
        }
        
        $path = storage_path('app/' . $pendaftaran->$fileColumn);
        
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        
        return response()->download($path);
    }
}
