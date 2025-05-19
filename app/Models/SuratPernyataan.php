<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPernyataan extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_surat_pernyataan',
        'status',
        'nim'
    ];

    protected $table = 'surat_pernyataan'; // tambahkan ini
    protected $primaryKey = 'id_surat_pernyataan'; // tambahkan ini juga kalau primary key bukan 'id'
    public $timestamps = true; // kalau kamu pakai kolom created_at & updated_at
}