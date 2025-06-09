<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level_id' => 1, 'level_kode' => 'SprAdmin', 'level_nama' => 'Super Admin'],
            ['level_id' => 2, 'level_kode' => 'AdmUpa', 'level_nama' => 'Admin UPA'],
            ['level_id' => 3, 'level_kode' => 'AdmITC', 'level_nama' => 'Admin ITC'],
            ['level_id' => 4, 'level_kode' => 'Mhs', 'level_nama' => 'Mahasiswa'],
            ['level_id' => 5, 'level_kode' => 'Alum', 'level_nama' => 'Alumni'],
            ['level_id' => 6, 'level_kode' => 'Dsn', 'level_nama' => 'Dosen'],
            ['level_id' => 7, 'level_kode' => 'Cvts', 'level_nama' => 'Civitas Akademika'],
        ];

        foreach ($data as $level) {
            DB::table('level')->updateOrInsert(
                ['level_id' => $level['level_id']],
                $level
            );
        }
    }
}
