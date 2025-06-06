<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::table('admins')->insert(
            [
                'name' => 'super_admin',
                'email' => 'super_admin@gmail.com',
                'phone' => '+123456779',
                'image' => 'https://linktest.gastwerk-bern.ch/storage/uploads/images/settings/app_logo1730468704.jpeg',
                'password' => Hash::make('123456789'), // Ensure password is hashed
                'parent_admin_id' =>null ,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        Admin::create([
            'name' => 'مالك صيدلية',
            'email' => 'owner@example.com',
            'phone' => '0500000000',
            'status_approved_for_pharmacy' => 'pending',
            'parent_admin_id' =>null ,
            'password' => Hash::make('password'), // تأكد من التشفير
            'status' => 'active',
        ]);

        Admin::create([
            'name' => ' 2 مالك صيدلية',
            'email' => 'owner2@example.com',
            'phone' => '0500000000',
            'status_approved_for_pharmacy' => 'pending',
            'parent_admin_id' =>null ,
            'password' => Hash::make('password'), // تأكد من التشفير
            'status' => 'active',
        ]);
    }
}
