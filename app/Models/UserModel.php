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

    protected $fillable = ['username', 'password', 'level_id', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];


    // relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // Get the role (level_kode) of the user
    public function getRole()
    {
        return $this->level->level_kode ?? null;
    }

    // Check if user has a specific role
    public function hasRole($role)
    {
        return $this->getRole() === $role;
    }
}
