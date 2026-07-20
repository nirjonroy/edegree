<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin24@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]
        );
    }
}
