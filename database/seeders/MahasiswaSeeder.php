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
                'nim' => '2341760001',
                'user_id' => 3,
                'nama' => 'Mahasiswa A',
                'jurusan' => 'Teknologi Informasi',
                'alamat_asal' => 'Jakarta',
                'nik' => '123456789',
                'no_whatsapp' => '08123456789',
                'kampus' => 'Polinema',
                'program_studi' => 'Teknik Informatika',
                'alamat_saat_ini' => 'Malang',
            ],
            [
                'nim' => '2441760002',
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
