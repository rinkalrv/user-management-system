<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'user_name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // Change this password in production
                'user_type' => 'admin',
                'user_status' => 'active',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->warn('Email: admin@example.com');
            $this->command->warn('Password: admin123');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}