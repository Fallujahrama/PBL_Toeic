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
                'username' => 'adminupa',
                'password' => Hash::make('12345'),
                'level_id' => 1,
            ],
            [
                'username' => 'adminitc',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
            [
                'username' => '2341760001',
                'password' => Hash::make('12345'),
                'level_id' => 3,
            ],
            [
                'username' => '241760002',
                'password' => Hash::make('12345'),
                'level_id' => 3,
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
