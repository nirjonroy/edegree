<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = collect([
            'manage dashboard',
            'manage about',
            'manage site info',
            'manage custom pages',
            'manage contact page',
            'manage news',
            'manage universities',
            'manage programs',
            'manage blog',
            'manage roles',
            'manage permissions',
            'manage sliders',
        ])->map(fn (string $name) => Permission::findOrCreate($name, 'web'));

        $admin = User::updateOrCreate(
            ['email' => 'admin24@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]
        );

        $role = Role::findOrCreate('Super Admin', 'web');
        $role->syncPermissions($permissions);
        $admin->assignRole($role);
    }
}
