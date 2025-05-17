<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; // Nama tabel
    protected $primaryKey = 'nim'; // Primary key
    public $incrementing = false; // Karena primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe data primary key

    // Relasi ke tabel surat_pernyataan
    public function suratPernyataan()
    {
        return $this->hasOne(SuratPernyataanModel::class, 'nim', 'nim');
    }
}
