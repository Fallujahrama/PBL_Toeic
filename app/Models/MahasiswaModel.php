<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'mahasiswa'; // Nama tabel
    protected $primaryKey = 'nim'; // Primary key adalah 'nim'
    public $incrementing = false; // Karena 'nim' bukan auto-increment
    protected $keyType = 'string'; // Tipe data primary key adalah string

    // Kolom yang dapat diisi
    protected $fillable = [
        'nim',
        'user_id',
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
        return $this->hasOne(PendaftaranModel::class, 'nim', 'nim');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id_user'); // Relasi berdasarkan user_id
    }

    // Relasi ke surat pernyataan
    public function suratPernyataan()
    {
        return $this->hasMany(SuratPernyataanModel::class, 'nim', 'nim');
    }
}
