<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            'view.admin.dashboard',
            'view.customers',
            'create.customers',
            'create.employee',
            'edit.employee',
            'manage.employees',
            'manage.product.category',
            'manage.product.list',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
