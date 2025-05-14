<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    // Menyesuaikan nama tabel
    protected $table = 'hasil_ujian'; // Ganti dengan nama tabel yang sesuai

    // Jika tabel memiliki primary key selain 'id', tentukan di sini
    // protected $primaryKey = 'your_custom_primary_key';

    // Menambahkan kolom yang boleh diisi
    protected $fillable = ['pdfFileName', 'status', 'lastUpdated'];
}

