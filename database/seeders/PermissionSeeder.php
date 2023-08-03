<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // super admin
        $permissions[] = Permission::create(['name' => 'access dashboard']);
        $permissions[] = Permission::create(['name' => 'manage tickets']);
        $permissions[] = Permission::create(['name' => 'manage users']);
        // $permissions[] = Permission::create(['name' => 'manage news']);
        // $permissions[] = Permission::create(['name' => 'manage competitions']);
        // $permissions[] = Permission::create(['name' => 'manage teams']);
        // $permissions[] = Permission::create(['name' => 'manage players']);
        // $permissions[] = Permission::create(['name' => 'manage users']);
        // $permissions[] = Permission::create(['name' => 'manage minimumcaramboles']);
        // $permissions[] = Permission::create(['name' => 'manage moyennes']);
        // $permissions[] = Permission::create(['name' => 'view logs']);
        // $permissions[] = Permission::create(['name' => 'view address']);

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);
        $admin = User::factory()->create([
            'name' => 'Jerry',
            'email' => 'admin@admin.com',
        ]);
        $admin->assignRole($adminRole);
    }
}
