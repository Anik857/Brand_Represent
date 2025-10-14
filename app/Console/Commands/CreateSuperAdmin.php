<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-superadmin {email=superadmin@example.com} {password=password123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a superadmin user with full access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists.");
            return 1;
        }

        // Create superadmin user
        $user = User::create([
            'name' => 'Super Admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Assign admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $user->assignRole($adminRole);
            $this->info("Superadmin user created successfully!");
            $this->info("Email: {$email}");
            $this->info("Password: {$password}");
        } else {
            $this->error("Admin role not found. Please run the RolePermissionSeeder first.");
            return 1;
        }

        return 0;
    }
}