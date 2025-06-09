<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'superadmin',
                'password' => Hash::make('12345'),
                'level_id' => 1,
            ],
            [
                'username' => 'adminupa',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
            [
                'username' => 'adminitc',
                'password' => Hash::make('12345'),
                'level_id' => 3,
            ],
            [
                'username' => '2441760001',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760002',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760003',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760004',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760005',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760006',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760007',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760008',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760009',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
            [
                'username' => '2441760010',
                'password' => Hash::make('12345'),
                'level_id' => 4,
            ],
        ];

        foreach ($data as $user) {
            DB::table('m_user')->updateOrInsert(
                ['username' => $user['username']], // Kondisi untuk mencocokkan data
                $user // Data yang akan diperbarui atau ditambahkan
            );
        }
        // DB::table('m_user')->insert($data);
    }
}
