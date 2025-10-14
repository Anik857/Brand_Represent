<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions with categories
        $permissions = [
            // Product permissions
            ['name' => 'view products', 'category' => 'products'],
            ['name' => 'create products', 'category' => 'products'],
            ['name' => 'edit products', 'category' => 'products'],
            ['name' => 'delete products', 'category' => 'products'],
            ['name' => 'manage products', 'category' => 'products'],
            
            // Category permissions
            ['name' => 'view categories', 'category' => 'categories'],
            ['name' => 'create categories', 'category' => 'categories'],
            ['name' => 'edit categories', 'category' => 'categories'],
            ['name' => 'delete categories', 'category' => 'categories'],
            ['name' => 'manage categories', 'category' => 'categories'],
            
            // Order permissions
            ['name' => 'view orders', 'category' => 'orders'],
            ['name' => 'create orders', 'category' => 'orders'],
            ['name' => 'edit orders', 'category' => 'orders'],
            ['name' => 'delete orders', 'category' => 'orders'],
            ['name' => 'manage orders', 'category' => 'orders'],
            
            // User permissions
            ['name' => 'view users', 'category' => 'users'],
            ['name' => 'create users', 'category' => 'users'],
            ['name' => 'edit users', 'category' => 'users'],
            ['name' => 'delete users', 'category' => 'users'],
            ['name' => 'manage users', 'category' => 'users'],
            
            // Dashboard permissions
            ['name' => 'view dashboard', 'category' => 'system'],
            ['name' => 'view reports', 'category' => 'system'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate([
                'name' => $permissionData['name']
            ], [
                'category' => $permissionData['category']
            ]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $managerRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view categories',
            'create categories',
            'edit categories',
            'view orders',
            'edit orders',
            'view dashboard',
            'view reports',
        ]);
        
        $employeeRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view categories',
            'view orders',
            'edit orders',
            'view dashboard',
        ]);
        
        $customerRole->givePermissionTo([
            'view products',
            'view categories',
        ]);

        // Assign admin role to existing admin user
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }
    }
}