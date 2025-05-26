<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    use HasFactory;

    protected $table = 'jadwal'; // Nama tabel
    protected $primaryKey = 'jadwal_id'; // Primary key
    protected $fillable = ['tanggal', 'informasi', 'file_info']; // Kolom yang dapat diisi

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranModel::class, 'jadwal_id', 'jadwal_id');
    }
}
