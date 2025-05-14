<?php

// Mahasiswa.php (Model)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'mahasiswa';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nim',
        'nama',
        'jurusan',
        'alamat_asal',
        'nik',
        'no_whatsapp',
        'kampus',
        'program_studi',
        'alamat_saat_ini',
    ];

    // Relasi ke tabel pendaftaran
    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class, 'nim', 'nim');
    }
}
