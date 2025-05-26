<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan halaman utama pendaftaran
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mendapatkan data yang diperlukan untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Pendaftaran',
            'list' => ['Home', 'Pendaftaran']
        ];

        $page = (object) [
            'title' => 'Pendaftaran Mahasiswa'
        ];

        $activeMenu = 'pendaftaran';  // Menandakan menu aktif

         // Cek apakah mahasiswa sudah pernah melakukan pendaftaran berdasarkan nim
        $nim = auth()->user()->nim; // Ambil NIM dari user yang sedang login
        $hasRegistered = PendaftaranModel::where('nim', $nim)->exists();

        // Menampilkan halaman index pendaftaran dengan path yang benar
        return view('mahasiswa.pendaftaran.index', compact('breadcrumb', 'page', 'activeMenu', 'hasRegistered'));
    }

    /**
     * Menampilkan form pendaftaran mahasiswa baru
     *
     * @return \Illuminate\View\View
     */
    public function createBaru()
    {
        $nim = auth()->user()->username; // Ambil NIM dari user yang sedang login

        // Cek apakah mahasiswa sudah pernah mendaftar berdasarkan nim
        $hasRegistered = PendaftaranModel::where('nim', $nim)->exists();

        if ($hasRegistered) {
            return redirect()->route('pendaftaran.index')->with('error', 'You have already registered. Please use Second Registration.');
        }

        // Mendapatkan data breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Pendaftaran Mahasiswa Baru',
            'list' => ['Home', 'Pendaftaran', 'Mahasiswa Baru']
        ];

        $page = (object) [
            'title' => 'Form Pendaftaran Mahasiswa Baru'
        ];

        $activeMenu = 'pendaftaran';  // Menandakan menu aktif

        // Menampilkan form pendaftaran untuk mahasiswa baru
        return view('mahasiswa.pendaftaran.baru', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function showPendaftaranLama(Request $request)
    {
        $mahasiswa = null;

        if ($request->has('nim')) {
            // Ambil data mahasiswa berdasarkan NIM
            $mahasiswa = MahasiswaModel::where('nim', $request->nim)->first();
        }

        return view('mahasiswa.pendaftaran.lama', compact('mahasiswa'));
    }

    /**
     * Get student data by NIM
     *
     * @param string $nim
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMahasiswa($nim)
    {
        $mahasiswa = MahasiswaModel::where('nim', $nim)->first();

        if ($mahasiswa) {
            return response()->json([
                'status' => 'success',
                'data' => $mahasiswa
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data mahasiswa tidak ditemukan'
        ]);
    }


    /**
     * Menampilkan form pendaftaran mahasiswa lama
     *
     * @return \Illuminate\View\View
     */
    public function createLama()
    {
        // Mendapatkan data breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Pendaftaran Mahasiswa Lama',
            'list' => ['Home', 'Pendaftaran', 'Mahasiswa Lama']
        ];

        $page = (object) [
            'title' => 'Form Pendaftaran Mahasiswa Lama'
        ];

        $activeMenu = 'pendaftaran';  // Menandakan menu aktif

        // Get logged-in user's student data
        $mahasiswa = MahasiswaModel::where('user_id', auth()->id())->first();

        // Menampilkan form pendaftaran untuk mahasiswa lama
        return view('mahasiswa.pendaftaran.lama', compact('breadcrumb', 'page', 'activeMenu', 'mahasiswa'));
    }

    public function storeBaru(Request $request)
    {
        // Validasi input mahasiswa baru
        $request->validate([
            // 'nim' => 'required|integer|unique:mahasiswa,nim',  // Validasi NIM di tabel mahasiswa
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'wa' => 'required|string|max:15',
            'alamat_asal' => 'required|string',
            'alamat_sekarang' => 'required|string',
            'prodi' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'kampus' => 'required|string',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'scan_ktm' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

         // Ambil NIM dari user yang sedang login
        $nim = auth()->user()->username;

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswa = MahasiswaModel::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('pendaftaran.index')->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Menyimpan data mahasiswa tanpa kolom ktp, scan_ktm, pas_foto
        // $mahasiswa = new MahasiswaModel();
        // $mahasiswa->nim = auth()->user()->username; // Ambil NIM dari username user yang sedang login
        $mahasiswa->nama = $request->nama;
        $mahasiswa->nik = $request->nik;
        $mahasiswa->no_whatsapp = $request->wa;
        $mahasiswa->alamat_asal = $request->alamat_asal;
        $mahasiswa->alamat_saat_ini = $request->alamat_sekarang;
        $mahasiswa->program_studi = $request->prodi;
        $mahasiswa->jurusan = $request->jurusan;
        $mahasiswa->kampus = $request->kampus;
        // $mahasiswa->user_id = auth()->id(); // This will use the currently logged-in user's ID
        $mahasiswa->save();

        // Perbarui nama di tabel m_user
        $user = auth()->user(); // Ambil data user yang sedang login
        $user->nama = $request->nama; // Perbarui kolom nama
        $user->save();

        $pendaftaran = new PendaftaranModel();
        $pendaftaran->nim = $nim;
        $pendaftaran->file_ktp = $request->hasFile('ktp') ? $request->file('ktp')->store('ktp') : null;
        $pendaftaran->file_ktm = $request->hasFile('scan_ktm') ? $request->file('scan_ktm')->store('scan_ktm') : null;
        $pendaftaran->file_foto = $request->hasFile('pas_foto') ? $request->file('pas_foto')->store('pas_foto') : null;
        $pendaftaran->file_bukti_pembayaran = null; // Tambahkan nilai default

        // Tambahkan ini untuk file_bukti_pembayaran
        // $pendaftaran->file_bukti_pembayaran = $request->hasFile('bukti_pembayaran') ? $request->file('bukti_pembayaran')->store('bukti_pembayaran') : null;

        $pendaftaran->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Successfully Register TOEIC Exam!');
    }

    /**
     * Store data pendaftaran mahasiswa lama
     */
    public function storeLama(Request $request)
    {
        // Validasi input mahasiswa lama
        $request->validate([
            'nim' => 'required|integer|exists:mahasiswa,nim', // Memastikan mahasiswa sudah terdaftar
            'file_bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // File KTP opsional
            'file_ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // File KTM opsional
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // File Foto opsional
        ]);

        // Menyimpan bukti pembayaran
        // $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran');

        // Just store the file but don't assign it to the model:
        if ($request->hasFile('file_bukti_pembayaran')) {
            $request->file('file_bukti_pembayaran')->store('file_bukti_pembayaran');
        }

        // Mendapatkan data mahasiswa
        $mahasiswa = MahasiswaModel::where('nim', $request->nim)->first();

        // Check if the student already has a previous registration to reuse file paths
        $previousRegistration = PendaftaranModel::where('nim', $request->nim)->latest()->first();

        // Provide default values for required fields
        $ktpPath = $request->hasFile('file_ktp')
            ? $request->file('file_ktp')->store('file_ktp')
            : ($previousRegistration ? $previousRegistration->file_ktp : 'default/default_ktp.jpg');

        $ktmPath = $request->hasFile('file_ktm')
            ? $request->file('file_ktm')->store('file_ktm')
            : ($previousRegistration ? $previousRegistration->file_ktm : 'default/default_ktm.jpg');

        $fotoPath = $request->hasFile('file_foto')
            ? $request->file('file_foto')->store('file_foto')
            : ($previousRegistration ? $previousRegistration->file_foto : 'default/default_foto.jpg');

        $buktiPembayaranPath = $request->hasFile('file_bukti_pembayaran')
            ? $request->file('file_bukti_pembayaran')->store('file_bukti_pembayaran')
            : ($previousRegistration ? $previousRegistration->file_bukti_pembayaran : 'default/default_bukti_pembayaran.jpg');

        // Menyimpan data pendaftaran untuk mahasiswa lama
        $pendaftaran = new PendaftaranModel();
        $pendaftaran->nim = $mahasiswa->nim;
        $pendaftaran->file_ktp = $ktpPath; // Jika ada, jika tidak null maka akan disimpan
        $pendaftaran->file_ktm = $ktmPath; // Jika ada, jika tidak null maka akan disimpan
        $pendaftaran->file_foto = $fotoPath; // Jika ada, jika tidak null maka akan disimpan
        $pendaftaran->file_bukti_pembayaran = $buktiPembayaranPath;
        $pendaftaran->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Successfully Register TOEIC Exam!');
    }
}
