<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Administrator',
                'email' => 'admin@fmapmedia.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'System Administrator',
                'email' => 'support@fmapmedia.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($admins as $admin) {

            $user = User::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );

            $user->assignRole('Admin');
        }
    }
}