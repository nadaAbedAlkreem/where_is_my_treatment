<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PharmaciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Pharmacy::create([
            'admin_id' => 2,
            'name_pharmacy' => 'صيدلية الربيع',
            'image_pharmacy' => 'pharmacy.jpg',
            'license_number' => 'LIC123456',
            'license_file_path' => 'licenses/license123.pdf',
            'license_expiry_date' => now()->addYear(),
            'phone_number_pharmacy' => '0555555555',
            'email_pharmacy' => 'pharmacy@example.com',
            'status_exist' => 'open',
            'description' => 'صيدلية متخصصة في الأدوية والمستلزمات الطبية.',
            'working_hours' => 'من 8 صباحًا إلى 10 مساءً',
        ]);



    }
}
