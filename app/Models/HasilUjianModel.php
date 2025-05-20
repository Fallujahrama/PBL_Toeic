<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjianModel extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian'; // Nama tabel
    protected $primaryKey = 'id_hasil'; // Primary key
    protected $fillable = ['tanggal', 'file_nilai', 'jadwal_id']; // Kolom yang dapat diisi

    // Relasi ke model Jadwal
    public function jadwal()
    {
        return $this->belongsTo(JadwalModel::class, 'jadwal_id', 'jadwal_id');
    }
}