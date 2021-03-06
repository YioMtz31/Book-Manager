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
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User1',
            'email' => 'user1@email.com',
            'password' => Hash::make('password'),
            'is_admin' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@email.com',
            'password' => Hash::make('password'),
        ]);
    }
}
