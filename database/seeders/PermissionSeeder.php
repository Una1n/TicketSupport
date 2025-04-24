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

        $permissions[] = Permission::create(['name' => 'access logs']);
        $permissions[] = Permission::create(['name' => 'manage tickets']);
        $permissions[] = Permission::create(['name' => 'manage users']);
        $permissions[] = Permission::create(['name' => 'manage categories']);
        $permissions[] = Permission::create(['name' => 'manage labels']);
        $addCommentsPermission = Permission::create(['name' => 'add comments']);
        $permissions[] = $addCommentsPermission;

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);
        User::factory()->admin()->create([
            'name' => 'Jerry',
            'email' => 'admin@admin.com',
        ]);

        $agentRole = Role::create(['name' => 'Agent']);
        $agentRole->givePermissionTo([
            Permission::create(['name' => 'edit tickets']),
            $addCommentsPermission,
        ]);

        $regularRole = Role::create(['name' => 'Regular']);
        $regularRole->givePermissionTo([
            $addCommentsPermission,
        ]);
    }
}
