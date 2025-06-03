<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'locationable_id' => 1, // ID of the related model (e.g., Store/User)
            'locationable_type' => 'App\Models\Pharmacy', // Fully qualified model name
            'latitude' =>  31.506159,
            'longitude' => 34.462556,
            'formatted_address' => 'Gaza City, Gaza Strip, Palestine',
            'country' => 'Palestine',
            'region' => 'Gaza Strip',
            'city' => 'Gaza',
            'district' => 'Gaza',
            'postal_code' => 'P100',
            'location_type' => 'office',

        ]);
    }
}
