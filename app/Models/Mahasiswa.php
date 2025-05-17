<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    
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
        'alamat_saat_ini'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'nim', 'nim');
    }
}