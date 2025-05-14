<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        // Add other fields as needed
    ];

    /**
     * Get the pendaftaran associated with the mahasiswa.
     */
    public function pendaftaran()
    {
        return $this->hasOne(PendaftaranModel::class, 'nim', 'nim');
    }
}
