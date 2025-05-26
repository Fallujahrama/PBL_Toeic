<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarLamaModel extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_lama';

    protected $fillable = [
        'nim', 'nama', 'prodi', 'jurusan', 'kampus', 'bukti_pembayaran',
    ];
}
