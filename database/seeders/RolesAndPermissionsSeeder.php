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

            // 🟢 Dashboard
            'view dashboard',

            // 🟡 Settings
            'add setting', 'view setting', 'edit setting', 'delete setting',

            // 🟠 Admins (المشرفين)
            'add admin', 'view admin', 'edit admin', 'delete admin',

            // 🔵 Pharmacy Owners (مالكو الصيدليات)
            'add pharmacy_owner', 'view pharmacy_owner', 'edit pharmacy_owner', 'delete pharmacy_owner',

            // 🟣 Employees (الموظفين)
            'add employee', 'view employee', 'edit employee', 'delete employee',

            // 🟤 App Users (مستخدمو التطبيق)
            'add app_user', 'view app_user', 'edit app_user', 'delete app_user',

            // 🧩 Roles & Permissions
            'add role', 'view role', 'edit role', 'delete role', 'assign permissions',

            // 🧪 Categories
            'add category', 'view category', 'edit category', 'delete category',

            // 💊 Medicines
            'add medicine', 'view medicine', 'edit medicine', 'delete medicine',

            // 📦 Pharmacy Stock
            'add pharmacy_stock', 'view pharmacy_stock', 'edit pharmacy_stock', 'delete pharmacy_stock',
        ];

        // إنشاء كل الصلاحيات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        // إنشاء الأدوار
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $pharmacyOwner = Role::firstOrCreate(['name' => 'pharmacy_owner', 'guard_name' => 'admin']);
        $employee = Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'admin']);

        // صلاحيات المشرف
        $allPermissions = Permission::all()->pluck('name')->toArray();

// استثناء الصلاحيات الغير مسموحة
        $excludedPermissions = [
            'add pharmacy_stock',
            'edit pharmacy_stock',
            'delete pharmacy_stock',
        ];

// إزالة الصلاحيات المستثناة من المجموعة
        $filteredPermissions = array_diff($allPermissions, $excludedPermissions);

// مزامنة الصلاحيات المسموح بها مع دور admin
        $admin->syncPermissions($filteredPermissions);
        // صلاحيات مالك الصيدلية
        $pharmacyOwner->syncPermissions([
            'view dashboard' ,
            // Medicines
            'add medicine', 'view medicine',

            // Categories
             'view category',
            // Employees (يمكنه إدارة موظفيه)
            'add employee', 'view employee', 'edit employee', 'delete employee',

            // Pharmacy Stock
            'add pharmacy_stock', 'view pharmacy_stock', 'edit pharmacy_stock', 'delete pharmacy_stock',
        ]);

        // صلاحيات الموظف
        $employee->syncPermissions([
          'view dashboard' ,  'view category',  'view medicine', 'add pharmacy_stock', 'view pharmacy_stock', 'edit pharmacy_stock', 'delete pharmacy_stock',
        ]);

        // ربط المستخدمين
        if ($adminUser = Admin::find(1)) {
            $adminUser->assignRole('admin');
        }

        if ($ownerUser = Admin::find(2)) {
            $ownerUser->assignRole('pharmacy_owner');
        }

        if ($ownerUser = Admin::find(3)) {
            $ownerUser->assignRole('pharmacy_owner');
        }

        if ($staffUser = Admin::find(4)) {
            $staffUser->assignRole('employee');
        }
    }
}
