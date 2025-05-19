<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function surat()
    {
        return $this->hasMany(SuratPernyataan::class, 'nim', 'nim');
    }
}
