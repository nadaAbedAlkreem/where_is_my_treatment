<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $users = User::factory()
//            ->count(20)
//            ->create();
        $this->call([
//            AdminSeeder::class,
//            PharmaciesSeeder::class,
//
            RolesAndPermissionsSeeder::class,
//             LocationSeeder::class
        ]);
    }
}
