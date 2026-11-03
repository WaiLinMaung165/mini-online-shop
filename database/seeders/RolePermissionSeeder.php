<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $permissions = [
            'access-admin',
            'categories.index',
            'categories.create',
            'categories.edit',
            'categories.delete',
            'products.index',
            'products.create',
            'products.edit',
            'products.delete',
            'orders.index',
            'orders.show',
            'orders.updatestatus',
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',
            'support.index',
            'support.reply',
            'orders.index',
            'orders.show',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'inventory-manager']);
        $officer = Role::firstOrCreate(['name' => 'order-officer']);
        $support = Role::firstOrCreate(['name' => 'customer-support']);

        $manager->givePermissionTo([
            'access-admin',
            'categories.index',
            'categories.create',
            'categories.edit',
            'categories.delete',
            'products.index',
            'products.create',
            'products.edit',
            'products.delete',
        ]);

        $officer->givePermissionTo([
            'access-admin',
            'orders.index',
            'orders.show',
            'orders.updatestatus'
        ]);
        $support->givePermissionTo([
            'access-admin',
            'support.index',
            'support.reply',
        ]);
    }
}
