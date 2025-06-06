<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $latitude = 31.505;
        $longitude = 35.505;

        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'), // كلمة مرور افتراضية
            'image' => null,
            'is_online' => true,
        ]);

         $user->location()->create([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'formatted_address' => 'عمان، الأردن',
            'country' => 'الأردن',
            'region' => 'عمان',
            'city' => 'عمان',
            'district' => 'جبل الحسين',
            'postal_code' => '11194',
            'location_type' => 'user',
        ]);
    }
}
