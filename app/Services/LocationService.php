<?php

namespace App\Services;

use App\Models\Location;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;


class LocationService
{
    use ResponseTrait ;
    public function getLocationDetails($pharmacyId , $pharmacyType ,$latitude, $longitude)
    {
         $response = Http::withHeaders([
            'User-Agent' => 'MyGraduationProject (elkahloutnada@gmail.com)',
        ])->get("https://nominatim.openstreetmap.org/reverse", [
            'lat' => $latitude,
            'lon' => $longitude,
            'format' => 'json',
            'addressdetails' => 1,
            'accept-language' => 'ar',
        ]);

        if ($response->failed()) {
            return null;
        }


        $data = $response->json();

        $address = $data['address'] ?? [];
        $exists = Location::where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->exists();

        if ($exists) {
            throw new \Exception('هذا الموقع موجود مسبقًا بخط الطول والعرض نفسه.');

        }

        return [
            'formatted_address' => $data['display_name'] ?? null,
            'locationable_id' => $pharmacyId,
            'locationable_type' => $pharmacyType,
            'latitude' =>$latitude ,
            'longitude' =>$longitude ,
            'country'           => $address['country'] ?? null,
            'region'            => $address['state'] ?? null,
            'city'              => $address['city'] ?? $address['town'] ?? $address['village'] ?? null,
            'district'          => $address['suburb'] ?? $address['neighbourhood'] ?? null,
            'postal_code'       => $address['postcode'] ?? null,
            'location_type'       => 'pharmacy',
        ];

}




}
