<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nik' => '123456789',
            'role' => 'admin',
            'password' => Hash::make('bismillah'), // Hash password untuk keamanan
        ]);
    }
}
