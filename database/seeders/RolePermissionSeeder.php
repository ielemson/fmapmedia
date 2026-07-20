<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage vendors',
            'manage magazines',
            'manage orders',
            'manage commissions',
            'manage payouts',
            'view vendor dashboard',
            'view admin dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $vendor = Role::firstOrCreate(['name' => 'Vendor']);
        $customer = Role::firstOrCreate(['name' => 'Customer']);

        $admin->syncPermissions($permissions);

        $vendor->syncPermissions([
            'view vendor dashboard',
        ]);

        $customer->syncPermissions([]);
    }
}