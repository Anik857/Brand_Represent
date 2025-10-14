<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );

        // Create test user
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
            ]
        );

        // Assign roles
        $superadmin->assignRole('admin');
        $admin->assignRole('admin');
        $testUser->assignRole('employee');

        $this->command->info('Users created successfully!');
        $this->command->info('Super Admin Email: superadmin@example.com');
        $this->command->info('Super Admin Password: password123');
        $this->command->info('Admin Email: admin@example.com');
        $this->command->info('Admin Password: password123');
        $this->command->info('Test Email: test@example.com');
        $this->command->info('Test Password: password123');
    }
}
