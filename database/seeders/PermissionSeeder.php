<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions[] = Permission::create(['name' => 'access dashboard']);
        $permissions[] = Permission::create(['name' => 'access logs']);
        $permissions[] = Permission::create(['name' => 'manage tickets']);
        $permissions[] = Permission::create(['name' => 'manage users']);
        $permissions[] = Permission::create(['name' => 'manage categories']);
        $permissions[] = Permission::create(['name' => 'manage labels']);

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);
        $admin = User::factory()->create([
            'name' => 'Jerry',
            'email' => 'admin@admin.com',
        ]);
        $admin->assignRole($adminRole);

        $agentRole = Role::create(['name' => 'Agent']);
        $agentRole->givePermissionTo([
            Permission::create(['name' => 'edit tickets']),
            Permission::create(['name' => 'add comments']),
        ]);
    }
}
