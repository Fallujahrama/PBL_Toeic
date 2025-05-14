<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarBaru extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_baru';

    protected $fillable = [
        'nim', 'nama', 'nik', 'wa', 'alamat_asal', 'alamat_sekarang',
        'prodi', 'jurusan', 'kampus', 'ktp', 'scan_ktm', 'pas_foto',
    ];
}
