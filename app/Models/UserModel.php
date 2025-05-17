<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; //mendefinisikan nama tabel yang digunakan model
    protected $primaryKey = 'id_user'; //mendefinisikan primary key dari tabel

    protected $fillable = ['username', 'password', 'level_id', 'foto_profil', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];


    // relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //mendapat nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    // cek apakah user memiliki role tertentu
    public function hasRole($role) : bool
    {
        return $this->level->level_kode == $role;
    }

    //mendapat kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }

    public function mahasiswa()
    {
        return $this->hasOne(MahasiswaModel::class, 'nim', 'username'); // Relasi berdasarkan NIM
    }
}
