<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Adjust if your User model is elsewhere
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeed extends Seeder
{
    public function run()
    {
        // Define all your permissions here (or you can fetch from DB if already created)
        $permissions = [
            'masuk.view', 'masuk.create', 'masuk.update', 'masuk.delete',
            'keluar.view', 'keluar.update', 'keluar.delete',
            'peminjaman.view', 'peminjaman.update', 'peminjaman.delete',
            'report.view',
            'pengaturan.view', 'pengaturan.create', 'pengaturan.update', 'pengaturan.delete',
            'users.view', 'users.create', 'users.update', 'users.delete',
            // Add any other permissions you have
        ];

        // Create or get all permissions in DB
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create superadmin role or get it
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Assign all permissions to superadmin role
        $superadminRole->syncPermissions($permissions);

        // Create a superadmin user or get existing one
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // change email
            [
                'name' => 'Super Admin',
                'password' => bcrypt('superadmin'), // change password
            ]
        );

        // Assign role to user
        $user->assignRole($superadminRole);
    }
}
