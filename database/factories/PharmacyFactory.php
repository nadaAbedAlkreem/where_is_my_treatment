<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{
    protected $model = Pharmacy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
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
        ];
    }
}
