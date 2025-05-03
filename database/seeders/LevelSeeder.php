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
            ['level_id' => 1, 'level_kode' => 'AdmUpa', 'level_nama' => 'Admin UPA'],
            ['level_id' => 2, 'level_kode' => 'AdmITC', 'level_nama' => 'Admin ITC'],
            ['level_id' => 3, 'level_kode' => 'Mhs', 'level_nama' => 'Mahasiswa'],
        ];

        DB::table('level')->insert($data);
    }
}
