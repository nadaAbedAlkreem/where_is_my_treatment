<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pharmacies = Pharmacy::all();

        foreach ($pharmacies as $pharmacy) {
            $latitude = 31.5 + mt_rand(-100, 100) / 1000;
            $longitude = 35.5 + mt_rand(-100, 100) / 1000;

            $pharmacy->location()->create([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'formatted_address' => 'عمان، الأردن',
                'country' => 'الأردن',
                'region' => 'عمان',
                'city' => 'عمان',
                'district' => 'وسط البلد',
                'postal_code' => '11118',
                'location_type' => 'pharmacy',
            ]);
        }
    }
}
