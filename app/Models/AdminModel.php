<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'admin'; // Nama tabel di database
    protected $primaryKey = 'id_admin'; // Primary key tabel

    protected $fillable = [
        'user_id', // Foreign key ke tabel m_user
        'nama',    // Nama admin
        'no_hp',  // Nomor handphone admin
    ];

    // Relasi ke tabel m_user
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id_user');
    }
}
