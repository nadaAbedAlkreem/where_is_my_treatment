<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Settings (الإعدادات)
            'add setting',
            'view setting',
            'edit setting',
            'delete setting',

            // Categories (الفئات)
            'add category',
            'view category',
            'edit category',
            'delete category',

            // Medicines (الأدوية)
            'add medicine',
            'view medicine',
            'edit medicine',
            'delete medicine',

            // Employees (الموظفين)
            'add employee',
            'view employee',
            'edit employee',
            'delete employee',

            // Admins (المشرفين)
            'add admin',
            'view admin',
            'edit admin',
            'delete admin',
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $pharmacyOwner = Role::firstOrCreate(['name' => 'pharmacy_owner', 'guard_name' => 'admin']);
        $employee = Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'admin']);
        $admin->syncPermissions(Permission::all());
        $user = Admin::find(1);
        $user->assignRole('admin');
        $user_ = Admin::find(2);
        $user_->assignRole('pharmacy_owner');
        $pharmacyOwner->syncPermissions([
            'add medicine',
            'edit medicine',
            'delete medicine',
            'view medicine',

            'add employee',
            'view employee',
            'edit employee',
            'delete employee',

        ]);

        $employee->syncPermissions([
            'add medicine',
            'edit medicine',
            'delete medicine',
            'view medicine',

        ]);
    }
}
