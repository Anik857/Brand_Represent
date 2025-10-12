<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@brandrepresent.com',
            'password' => Hash::make('password123'),
        ]);

        // Create a test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@brandrepresent.com',
            'password' => Hash::make('password123'),
        ]);

        $this->command->info('Admin users created successfully!');
        $this->command->info('Admin Email: admin@brandrepresent.com');
        $this->command->info('Admin Password: password123');
        $this->command->info('Test Email: test@brandrepresent.com');
        $this->command->info('Test Password: password123');
    }
}
