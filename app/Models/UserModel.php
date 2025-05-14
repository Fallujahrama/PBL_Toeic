<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserModel extends Model
{
    // public function level() : HasOne {
    //     return $this->hasOne(LevelModel::class);
    // }

    use HasFactory;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    /**
     * The atributes that are mass assignable
     * 
     * @var array
     */
    
     protected $fillable = [
        'username',
        'nama',
        'password',
        'level_id'
    ];

    public function level() : BelongsTo{
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }


}
