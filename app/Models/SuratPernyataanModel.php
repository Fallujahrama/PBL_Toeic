<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPernyataanModel extends Model
{
    use HasFactory;

    protected $table = 'surat_pernyataan'; // Nama tabel
    protected $primaryKey = 'id_surat_pernyataan'; // Primary key
    protected $fillable = ['file_surat_pernyataan', 'status', 'nim']; // Kolom yang dapat diisi

    // Relasi ke tabel mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
}
