<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $nim = auth()->user()->username; // Ubah dari nim ke username
        $hasRegistered = PendaftaranModel::where('nim', $nim)->exists();
        
        // Get registration history
        $registrations = $this->getRegistrationHistory();

        // Menampilkan halaman index pendaftaran dengan path yang benar
        return view('mahasiswa.pendaftaran.index', compact('breadcrumb', 'page', 'activeMenu', 'hasRegistered', 'registrations'));
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
        $pendaftaran->file_ktp = $request->hasFile('ktp') ? $request->file('ktp')->store('pendaftaran/ktp', 'public') : null;
        $pendaftaran->file_ktm = $request->hasFile('scan_ktm') ? $request->file('scan_ktm')->store('pendaftaran/ktm', 'public') : null;
        $pendaftaran->file_foto = $request->hasFile('pas_foto') ? $request->file('pas_foto')->store('pendaftaran/foto', 'public') : null;
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

        // Mendapatkan data mahasiswa
        $mahasiswa = MahasiswaModel::where('nim', $request->nim)->first();

        // Check if the student already has a previous registration to reuse file paths
        $previousRegistration = PendaftaranModel::where('nim', $request->nim)->latest()->first();

        // Provide default values for required fields
        $ktpPath = $request->hasFile('file_ktp')
            ? $request->file('file_ktp')->store('pendaftaran/ktp', 'public')
            : ($previousRegistration ? $previousRegistration->file_ktp : null);

        $ktmPath = $request->hasFile('file_ktm')
            ? $request->file('file_ktm')->store('pendaftaran/ktm', 'public')
            : ($previousRegistration ? $previousRegistration->file_ktm : null);

        $fotoPath = $request->hasFile('file_foto')
            ? $request->file('file_foto')->store('pendaftaran/foto', 'public')
            : ($previousRegistration ? $previousRegistration->file_foto : null);

        $buktiPembayaranPath = $request->hasFile('file_bukti_pembayaran')
            ? $request->file('file_bukti_pembayaran')->store('pendaftaran/bukti_pembayaran', 'public')
            : null;

        // Menyimpan data pendaftaran untuk mahasiswa lama
        $pendaftaran = new PendaftaranModel();
        $pendaftaran->nim = $mahasiswa->nim;
        $pendaftaran->file_ktp = $ktpPath;
        $pendaftaran->file_ktm = $ktmPath;
        $pendaftaran->file_foto = $fotoPath;
        $pendaftaran->file_bukti_pembayaran = $buktiPembayaranPath;
        $pendaftaran->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Successfully Register TOEIC Exam!');
    }

    /**
     * Show edit form for student data and registration files
     */
    public function editMahasiswa($nim)
    {
        $mahasiswa = MahasiswaModel::where('nim', $nim)->first();
        
        if (!$mahasiswa) {
            return redirect()->route('pendaftaran.index')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Get latest registration for this student
        $pendaftaran = PendaftaranModel::where('nim', $nim)->latest()->first();

        $breadcrumb = (object) [
            'title' => 'Edit Data Mahasiswa',
            'list' => ['Home', 'Pendaftaran', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Mahasiswa & Pendaftaran'
        ];

        $activeMenu = 'pendaftaran';

        return view('mahasiswa.pendaftaran.edit', compact('breadcrumb', 'page', 'activeMenu', 'mahasiswa', 'pendaftaran'));
    }

    /**
     * Update student data and registration files
     */
    public function updateMahasiswa(Request $request, $nim)
    {
        // Get the mahasiswa first
        $mahasiswa = MahasiswaModel::where('nim', $nim)->first();
        
        if (!$mahasiswa) {
            return redirect()->route('pendaftaran.index')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Check if this is a second registration
        $nim = auth()->user()->username;
        $registrationCount = PendaftaranModel::where('nim', $nim)->count();
        $isSecondRegistration = $registrationCount > 1;

        // Base validation rules
        $validationRules = [
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'kampus' => 'required|string|max:255',
            'alamat_asal' => 'required|string',
            'alamat_sekarang' => 'required|string',
            'nik' => 'required|string|max:16',
            'wa' => 'required|string|max:15',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];

        // Add bukti pembayaran validation only for second registrations
        if ($isSecondRegistration) {
            $validationRules['file_bukti_pembayaran'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240';
        }

        $request->validate($validationRules);

        // Update student data with correct field mapping
        $mahasiswa->update([
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'program_studi' => $request->prodi, // Form field 'prodi' maps to 'program_studi'
            'kampus' => $request->kampus,
            'alamat_asal' => $request->alamat_asal,
            'alamat_saat_ini' => $request->alamat_sekarang, // Form field 'alamat_sekarang' maps to 'alamat_saat_ini'
            'nik' => $request->nik,
            'no_whatsapp' => $request->wa, // Form field 'wa' maps to 'no_whatsapp'
        ]);

        // Update user name in m_user table
        $user = auth()->user();
        $user->nama = $request->nama;
        $user->save();

        // Update registration files if uploaded
        $pendaftaran = PendaftaranModel::where('nim', $nim)->latest()->first();
        if ($pendaftaran) {
            if ($request->hasFile('file_ktp')) {
                // Delete old file if exists
                if ($pendaftaran->file_ktp && Storage::disk('public')->exists($pendaftaran->file_ktp)) {
                    Storage::disk('public')->delete($pendaftaran->file_ktp);
                }
                $pendaftaran->file_ktp = $request->file('file_ktp')->store('pendaftaran/ktp', 'public');
            }
            
            if ($request->hasFile('file_ktm')) {
                // Delete old file if exists
                if ($pendaftaran->file_ktm && Storage::disk('public')->exists($pendaftaran->file_ktm)) {
                    Storage::disk('public')->delete($pendaftaran->file_ktm);
                }
                $pendaftaran->file_ktm = $request->file('file_ktm')->store('pendaftaran/ktm', 'public');
            }
            
            if ($request->hasFile('file_foto')) {
                // Delete old file if exists
                if ($pendaftaran->file_foto && Storage::disk('public')->exists($pendaftaran->file_foto)) {
                    Storage::disk('public')->delete($pendaftaran->file_foto);
                }
                $pendaftaran->file_foto = $request->file('file_foto')->store('pendaftaran/foto', 'public');
            }
            
            // Only process bukti pembayaran for second registrations
            if ($isSecondRegistration && $request->hasFile('file_bukti_pembayaran')) {
                // Delete old file if exists
                if ($pendaftaran->file_bukti_pembayaran && Storage::disk('public')->exists($pendaftaran->file_bukti_pembayaran)) {
                    Storage::disk('public')->delete($pendaftaran->file_bukti_pembayaran);
                }
                $pendaftaran->file_bukti_pembayaran = $request->file('file_bukti_pembayaran')->store('pendaftaran/bukti_pembayaran', 'public');
            }

            $pendaftaran->save();
        }

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Data mahasiswa dan pendaftaran berhasil diperbarui.');
    }

    /**
     * Get registration history for logged in student
     */
    public function getRegistrationHistory()
    {
        $nim = auth()->user()->username;
        $registrations = PendaftaranModel::where('nim', $nim)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return $registrations;
    }

    /**
     * Show student detail
     */
    public function showMahasiswa($nim)
    {
        $mahasiswa = MahasiswaModel::with('pendaftaran')->where('nim', $nim)->first();
        
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        return response()->json([
            'status' => 'success',
            'data' => $mahasiswa
        ]);
    }

    /**
     * Preview file method
     */
    public function previewFile($nim, $type)
    {
        $pendaftaran = PendaftaranModel::where('nim', $nim)->latest()->first();
        
        if (!$pendaftaran) {
            abort(404, 'Pendaftaran tidak ditemukan');
        }

        $filePath = null;
        switch ($type) {
            case 'ktp':
                $filePath = $pendaftaran->file_ktp;
                break;
            case 'ktm':
                $filePath = $pendaftaran->file_ktm;
                break;
            case 'foto':
                $filePath = $pendaftaran->file_foto;
                break;
            case 'bukti_pembayaran':
                $filePath = $pendaftaran->file_bukti_pembayaran;
                break;
            default:
                abort(404, 'Jenis file tidak valid');
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(storage_path('app/public/' . $filePath));
    }

    /**
     * Show registration details for AJAX request
     */
    public function show($id)
    {
        $pendaftaran = PendaftaranModel::with('mahasiswa')->find($id);
        
        if (!$pendaftaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pendaftaran tidak ditemukan'
            ], 404);
        }

        // Check if the registration belongs to the logged-in user
        $nim = auth()->user()->username;
        if ($pendaftaran->nim !== $nim) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $pendaftaran->id,
                'nim' => $pendaftaran->nim,
                'created_at' => $pendaftaran->created_at,
                'updated_at' => $pendaftaran->updated_at,
                'file_ktp' => $pendaftaran->file_ktp,
                'file_ktm' => $pendaftaran->file_ktm,
                'file_foto' => $pendaftaran->file_foto,
                'file_bukti_pembayaran' => $pendaftaran->file_bukti_pembayaran,
                'mahasiswa' => $pendaftaran->mahasiswa ? [
                    'nama' => $pendaftaran->mahasiswa->nama,
                    'program_studi' => $pendaftaran->mahasiswa->program_studi,
                    'jurusan' => $pendaftaran->mahasiswa->jurusan,
                    'kampus' => $pendaftaran->mahasiswa->kampus
                ] : null
            ]
        ]);
    }
}
