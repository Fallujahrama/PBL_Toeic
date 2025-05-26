<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranModel extends Model
{
    use HasFactory;
    
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    
    protected $fillable = [
        'nim',
        'file_ktp',
        'file_ktm',
        'file_foto',
        'status_verifikasi',
        'keterangan',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
}
