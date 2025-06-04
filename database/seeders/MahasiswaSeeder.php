<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nim' => '2441760001',
                'user_id' => 4,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760002',
                'user_id' => 5,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760003',
                'user_id' => 6,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760004',
                'user_id' => 7,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760005',
                'user_id' => 8,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760006',
                'user_id' => 9,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760007',
                'user_id' => 10,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760008',
                'user_id' => 11,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760009',
                'user_id' => 12,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
            [
                'nim' => '2441760010',
                'user_id' => 13,
                'nama' => null,
                'jurusan' => null,
                'alamat_asal' => null,
                'nik' => null,
                'no_whatsapp' => null,
                'kampus' => null,
                'program_studi' => null,
                'alamat_saat_ini' => null,
            ],
        ];

        foreach ($data as $mahasiswa) {
            DB::table('mahasiswa')->updateOrInsert(
                ['nim' => $mahasiswa['nim']], // Kondisi untuk mencocokkan data
                $mahasiswa // Data yang akan diperbarui atau ditambahkan
            );
        }
        // DB::table('mahasiswa')->insert($data);
    }
}
