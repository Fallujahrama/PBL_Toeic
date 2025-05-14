<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranModel;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendaftaran = PendaftaranModel::latest()->paginate(10);
        return view('pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('pendaftaran.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|exists:mahasiswa,nim',
            'file_ktp' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'file_ktm' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'file_foto' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal. Silakan periksa kembali data Anda.',
                'errors' => $validator->errors()
            ]);
        }

        try {
            // Handle file uploads
            $file_ktp = $request->file('file_ktp')->store('public/pendaftaran/ktp');
            $file_ktm = $request->file('file_ktm')->store('public/pendaftaran/ktm');
            $file_foto = $request->file('file_foto')->store('public/pendaftaran/foto');

            // Create pendaftaran
            PendaftaranModel::create([
                'nim' => $request->nim,
                'file_ktp' => str_replace('public/', '', $file_ktp),
                'file_ktm' => str_replace('public/', '', $file_ktm),
                'file_foto' => str_replace('public/', '', $file_foto),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pendaftaran berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendaftaran = PendaftaranModel::findOrFail($id);
        return view('pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pendaftaran = PendaftaranModel::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        return view('pendaftaran.edit', compact('pendaftaran', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = PendaftaranModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nim' => 'required|exists:mahasiswa,nim',
            'file_ktp' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'file_ktm' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'file_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal. Silakan periksa kembali data Anda.',
                'errors' => $validator->errors()
            ]);
        }

        try {
            // Update NIM
            $pendaftaran->nim = $request->nim;

            // Handle file uploads if provided
            if ($request->hasFile('file_ktp')) {
                // Delete old file
                Storage::delete('public/' . $pendaftaran->file_ktp);
                // Upload new file
                $file_ktp = $request->file('file_ktp')->store('public/pendaftaran/ktp');
                $pendaftaran->file_ktp = str_replace('public/', '', $file_ktp);
            }

            if ($request->hasFile('file_ktm')) {
                // Delete old file
                Storage::delete('public/' . $pendaftaran->file_ktm);
                // Upload new file
                $file_ktm = $request->file('file_ktm')->store('public/pendaftaran/ktm');
                $pendaftaran->file_ktm = str_replace('public/', '', $file_ktm);
            }

            if ($request->hasFile('file_foto')) {
                // Delete old file
                Storage::delete('public/' . $pendaftaran->file_foto);
                // Upload new file
                $file_foto = $request->file('file_foto')->store('public/pendaftaran/foto');
                $pendaftaran->file_foto = str_replace('public/', '', $file_foto);
            }

            $pendaftaran->save();

            return response()->json([
                'status' => true,
                'message' => 'Pendaftaran berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $pendaftaran = PendaftaranModel::findOrFail($id);

            // Delete files
            Storage::delete('public/' . $pendaftaran->file_ktp);
            Storage::delete('public/' . $pendaftaran->file_ktm);
            Storage::delete('public/' . $pendaftaran->file_foto);

            // Delete record
            $pendaftaran->delete();

            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
