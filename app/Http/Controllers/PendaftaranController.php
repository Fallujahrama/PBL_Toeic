<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Mahasiswa;
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

        // Menampilkan halaman index pendaftaran
        return view('pendaftaran.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    /**
     * Menampilkan form pendaftaran mahasiswa baru
     *
     * @return \Illuminate\View\View
     */
    public function formBaru()
    {
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
        return view('pendaftaran.baru', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function showPendaftaranLama(Request $request)
    {
        $mahasiswa = null;

        if ($request->has('nim')) {
            // Ambil data mahasiswa berdasarkan NIM
            $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        }

        return view('pendaftaran.lama', compact('mahasiswa'));
    }

    public function getMahasiswa($nim)
    {
        // Cari berdasarkan NIM
        $m = Mahasiswa::where('nim', $nim)->first();

        if (! $m) {
            // Kembalikan sukses= false agar fetch tetap resolve
            return response()->json([
                'status'  => 'error',
                'message' => "NIM {$nim} belum terdaftar di database."
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'nama'    => $m->nama,
                'jurusan' => $m->jurusan,
                'prodi'   => $m->program_studi,
            ],
        ], 200);
    }

    /**
     * Menampilkan form pendaftaran mahasiswa lama
     *
     * @return \Illuminate\View\View
     */
    public function formLama()
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

        // Menampilkan form pendaftaran untuk mahasiswa lama
        return view('pendaftaran.lama', compact('breadcrumb', 'page', 'activeMenu'));
    }

  public function storeBaru(Request $request)
    {
        // Validasi input mahasiswa baru
        $request->validate([
            'nim' => 'required|integer|unique:mahasiswa,nim',  // Validasi NIM di tabel mahasiswa
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

        // Menyimpan data mahasiswa tanpa kolom ktp, scan_ktm, pas_foto
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->nik = $request->nik;
        $mahasiswa->no_whatsapp = $request->wa;
        $mahasiswa->alamat_asal = $request->alamat_asal;
        $mahasiswa->alamat_saat_ini = $request->alamat_sekarang;
        $mahasiswa->program_studi = $request->prodi;
        $mahasiswa->jurusan = $request->jurusan;
        $mahasiswa->kampus = $request->kampus;
        $mahasiswa->save();

        $pendaftaran = new Pendaftaran();
        $pendaftaran->nim = $request->nim;
        $pendaftaran->file_ktp = $request->hasFile('ktp') ? $request->file('ktp')->store('ktp') : null;
        $pendaftaran->file_ktm = $request->hasFile('scan_ktm') ? $request->file('scan_ktm')->store('scan_ktm') : null;
        $pendaftaran->file_foto = $request->hasFile('pas_foto') ? $request->file('pas_foto')->store('pas_foto') : null;

        // Tambahkan ini untuk file_bukti_pembayaran
        $pendaftaran->file_bukti_pembayaran = $request->hasFile('bukti_pembayaran') ? $request->file('bukti_pembayaran')->store('bukti_pembayaran') : null;

        $pendaftaran->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Successfully Register TOEIC Exam!');
    }

    /**
     * Store data pendaftaran mahasiswa lama
     */
    public function storeLama(Request $request)
    {
        $nim = $request->input('nim');
        if (! Mahasiswa::where('nim', $nim)->exists()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "NIM anda belum terdaftar di database.");
        }

        $request->validate([
            'nim'               => 'required|integer',
            'bukti_pembayaran'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktp'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_ktm'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_foto'         => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ]);

        $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran');

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $ktpPath  = $request->hasFile('file_ktp')  ? $request->file('file_ktp')->store('file_ktp') : null;
        $ktmPath  = $request->hasFile('file_ktm')  ? $request->file('file_ktm')->store('file_ktm') : null;
        $fotoPath = $request->hasFile('file_foto') ? $request->file('file_foto')->store('file_foto') : null;

        $pendaftaran = new Pendaftaran();
        $pendaftaran->nim                   = $mahasiswa->nim;
        $pendaftaran->file_bukti_pembayaran = $buktiPembayaranPath;
        $pendaftaran->file_ktp              = $ktpPath;
        $pendaftaran->file_ktm              = $ktmPath;
        $pendaftaran->file_foto             = $fotoPath;
        $pendaftaran->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Successfully Register TOEIC Exam!');
    }

}
