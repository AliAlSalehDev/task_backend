<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* We Use Factory Too */

        // Global Password
        $password = "123123123";
        // Create
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Ali',
                'email' => 'user1@user.com',
                'password' => bcrypt($password),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Mohammad',
                'email' => 'user2@user.com',
                'password' => bcrypt($password),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Ahmad',
                'email' => 'user3@user.com',
                'password' => bcrypt($password),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
