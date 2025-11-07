<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- 1. Permissionlar ---
        $permissions = [
            'post view',
            'post create',
            'post update',
            'post delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // --- 2. Rollar ---
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        // --- 3. Role’ga permissionlarni biriktirish ---
        $admin->givePermissionTo(Permission::all()); // barcha ruxsat
        $editor->givePermissionTo(['post view', 'post create', 'post update']);
        $viewer->givePermissionTo(['post view']);

        // --- 4. Test userlar yaratish ---
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gm.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($admin);

        $editorUser = User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@gm.com',
            'password' => bcrypt('password'),
        ]);
        $editorUser->assignRole($editor);

        $viewerUser = User::factory()->create([
            'name' => 'Viewer User',
            'email' => 'viewer@gm.com',
            'password' => bcrypt('password'),
        ]);
        $viewerUser->assignRole($viewer);
    }
}
