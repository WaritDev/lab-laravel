<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('local')) {
                User::query()->createOrFirst([
                'email' => 'admin@example.com',
            ], [
                'name' => 'Admin Pleng',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
            ]);

            User::query()->createOrFirst([
                'email' => 'user@example.com',
            ], [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role' => 'USER',
            ]);
        }
    }
}
