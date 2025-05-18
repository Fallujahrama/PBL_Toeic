<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranModel extends Model
{
    use HasFactory;
    
    protected $table = 'pendaftaran';

    protected $fillable = [
        'nim',
        'file_ktp',
        'file_ktm',
        'file_foto',
        'file_bukti_pembayaran',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
}
