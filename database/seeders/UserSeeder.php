<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'type' => 'admin'
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'type' => 'user'
            ],
            [
                'name' => 'Client',
                'email' => 'client@gmail.com',
                'password' => Hash::make('password'),
                'type' => 'client'
            ]
        ];

        DB::table('users')->insertOrIgnore(
            $data
        );
    }
}
