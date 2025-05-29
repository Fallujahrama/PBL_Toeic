<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSuratModel extends Model
{
    use HasFactory;

    protected $table = 'template_surat';
    protected $primaryKey = 'id_template';
    public $timestamps = true;

    protected $fillable = [
        'nama_template',
        'file_template',
        'deskripsi',
        'status'
    ];
}
