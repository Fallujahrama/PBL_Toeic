<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'nama' => 'AdminUPA',
                'no_hp' => '08111111111',
            ],
            [
                'user_id' => 2,
                'nama' => 'AdminITC',
                'no_hp' => '08222222222',
            ],
        ];

        DB::table('admin')->insert($data);
    }
}
