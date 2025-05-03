<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $primaryKey = 'jadwal_id';

    protected $fillable = [
        'tanggal',
        'informasi',
        'file_info',
    ];
}