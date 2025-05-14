<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'notifikasi'; // Nama tabel
    protected $fillable = ['tanggal', 'pesan']; // Kolom yang dapat diisi
}