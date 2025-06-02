<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPernyataanModel extends Model
{
    use HasFactory;

    protected $table = 'surat_pernyataan';
    protected $primaryKey = 'id_surat_pernyataan';
    public $timestamps = true;

    protected $fillable = [
        'file_surat_pernyataan',
        'status',
        'nim'
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
}
