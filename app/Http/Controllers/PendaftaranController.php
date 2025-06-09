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
    try {
        // Debug: Log incoming request
        \Log::info('Registration form submitted', [
            'user_id' => auth()->id(),
            'username' => auth()->user()->username,
            'request_data' => $request->except(['ktp', 'scan_ktm', 'pas_foto'])
        ]);

        // Validasi input mahasiswa baru
        $validatedData = $request->validate([
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
        ], [
            'nama.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'wa.required' => 'Nomor WhatsApp wajib diisi',
            'alamat_asal.required' => 'Alamat asal wajib diisi',
            'alamat_sekarang.required' => 'Alamat sekarang wajib diisi',
            'prodi.required' => 'Program studi wajib diisi',
            'jurusan.required' => 'Jurusan wajib dipilih',
            'kampus.required' => 'Kampus wajib dipilih',
            'ktp.required' => 'File KTP wajib diupload',
            'ktp.mimes' => 'File KTP harus berformat JPG, JPEG, PNG, atau PDF',
            'ktp.max' => 'Ukuran file KTP maksimal 10MB',
            'scan_ktm.required' => 'File KTM wajib diupload',
            'scan_ktm.mimes' => 'File KTM harus berformat JPG, JPEG, PNG, atau PDF',
            'scan_ktm.max' => 'Ukuran file KTM maksimal 10MB',
            'pas_foto.required' => 'Pas foto wajib diupload',
            'pas_foto.mimes' => 'Pas foto harus berformat JPG, JPEG, atau PNG',
            'pas_foto.max' => 'Ukuran pas foto maksimal 2MB',
        ]);

        \Log::info('Validation passed');

        // Ambil NIM dari user yang sedang login
        $nim = auth()->user()->username;

        // Cek apakah mahasiswa sudah pernah mendaftar
        $hasRegistered = PendaftaranModel::where('nim', $nim)->exists();
        if ($hasRegistered) {
            \Log::warning('User already registered', ['nim' => $nim]);
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Anda sudah pernah mendaftar. Silakan gunakan pendaftaran kedua.');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswa = MahasiswaModel::where('nim', $nim)->first();

        if (!$mahasiswa) {
            \Log::error('Student data not found', ['nim' => $nim]);
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        \Log::info('Student found, updating data', ['nim' => $nim]);

        // Update data mahasiswa
        $mahasiswa->update([
            'nama' => $validatedData['nama'],
            'nik' => $validatedData['nik'],
            'no_whatsapp' => $validatedData['wa'],
            'alamat_asal' => $validatedData['alamat_asal'],
            'alamat_saat_ini' => $validatedData['alamat_sekarang'],
            'program_studi' => $validatedData['prodi'],
            'jurusan' => $validatedData['jurusan'],
            'kampus' => $validatedData['kampus'],
        ]);

        // Perbarui nama di tabel m_user
        $user = auth()->user();
        $user->nama = $validatedData['nama'];
        $user->save();

        \Log::info('Student and user data updated');

        // Menyimpan data pendaftaran
        $pendaftaran = new PendaftaranModel();
        $pendaftaran->nim = $nim;

        // Handle file uploads dengan error handling
        try {
            if ($request->hasFile('ktp')) {
                $file = $request->file('ktp');
                $filename = time() . '_ktp_' . $file->getClientOriginalName();
                $pendaftaran->file_ktp = $file->storeAs('pendaftaran/ktp', $filename, 'public');
                \Log::info('KTP file uploaded', ['filename' => $filename]);
            }

            if ($request->hasFile('scan_ktm')) {
                $file = $request->file('scan_ktm');
                $filename = time() . '_ktm_' . $file->getClientOriginalName();
                $pendaftaran->file_ktm = $file->storeAs('pendaftaran/ktm', $filename, 'public');
                \Log::info('KTM file uploaded', ['filename' => $filename]);
            }

            if ($request->hasFile('pas_foto')) {
                $file = $request->file('pas_foto');
                $filename = time() . '_foto_' . $file->getClientOriginalName();
                $pendaftaran->file_foto = $file->storeAs('pendaftaran/foto', $filename, 'public');
                \Log::info('Photo file uploaded', ['filename' => $filename]);
            }
        } catch (\Exception $e) {
            \Log::error('File upload error', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupload file. Silakan coba lagi.');
        }

        // Set file_bukti_pembayaran to null for first registration
        $pendaftaran->file_bukti_pembayaran = null;

        // Save pendaftaran
        $pendaftaran->save();

        \Log::info('Registration saved successfully', ['pendaftaran_id' => $pendaftaran->id]);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Pendaftaran TOEIC berhasil! Silakan tunggu konfirmasi dari admin.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation error', ['errors' => $e->errors()]);
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
    } catch (\Exception $e) {
        \Log::error('Registration error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.');
    }
}

    /**
     * Store data pendaftaran mahasiswa lama
     */
    public function storeLama(Request $request)
    {
        // Validasi input mahasiswa lama
        $request->validate([
            'file_bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Get NIM from logged-in user
        $nim = auth()->user()->username;

        // Get student data
        $mahasiswa = MahasiswaModel::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('pendaftaran.index')->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Check if the student already has a previous registration to reuse file paths
        $previousRegistration = PendaftaranModel::where('nim', $nim)->latest()->first();

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
        $pendaftaran->nim = $nim;
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

        // Get the latest registration for this student
        $pendaftaran = PendaftaranModel::where('nim', $nim)->latest()->first();

        // Update registration files if uploaded
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

            // Mark as edited
            $pendaftaran->keterangan = 'EDITED';
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

        if (!$filePath) {
        abort(404, 'File tidak ditemukan');
        }

        // Path lengkap ke file
        $fullPath = storage_path('app/public/' . $filePath);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di sistem');
        }

        // Get MIME type
        $mime = mime_content_type($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mime
        ]);
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
                'is_edited' => $pendaftaran->keterangan === 'EDITED',
                'mahasiswa' => $pendaftaran->mahasiswa ? [
                    'nama' => $pendaftaran->mahasiswa->nama,
                    'program_studi' => $pendaftaran->mahasiswa->program_studi,
                    'jurusan' => $pendaftaran->mahasiswa->jurusan,
                    'kampus' => $pendaftaran->mahasiswa->kampus
                ] : null
            ]
        ]);
    }

    /**
     * Show registration details
     */
    public function showRegistration($id)
    {
        $pendaftaran = PendaftaranModel::with('mahasiswa')->find($id);

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.index')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Check if the registration belongs to the logged-in user
        $nim = auth()->user()->username;
        if ($pendaftaran->nim !== $nim) {
            return redirect()->route('pendaftaran.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        // Check if registration has been edited
        if ($pendaftaran->keterangan === 'EDITED') {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Pendaftaran ini sudah diedit sebelumnya dan tidak dapat diakses lagi.');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Pendaftaran',
            'list' => ['Home', 'Pendaftaran', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Pendaftaran'
        ];

        $activeMenu = 'pendaftaran';

        return view('mahasiswa.pendaftaran.show', compact('breadcrumb', 'page', 'activeMenu', 'pendaftaran'));
    }
}
