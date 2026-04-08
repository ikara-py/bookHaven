<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'Platform Admin',
            'email' => 'admin@bookhaven.com',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'is_verified' => true,
            'status' => 'active',
        ]);
    }
}
