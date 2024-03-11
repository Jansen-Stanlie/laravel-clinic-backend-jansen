<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Polyclinic;
use Faker\Factory as Faker;

class dataDoctor extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all polyclinics
        $polyclinics = Polyclinic::all();

        // Loop through each polyclinic and seed doctors
        foreach ($polyclinics as $polyclinic) {
            // Generate random number of doctors for each polyclinic
            $numDoctors = $faker->numberBetween(1, 5);

            for ($i = 0; $i < $numDoctors; $i++) {
                Doctor::create([
                    'doctor_id' => $faker->unique()->randomNumber(6),
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'password' => bcrypt('password'), // Example password, you may change this
                    'role' => 'Doctor',
                    'degree' => $faker->randomElement(['MBBS', 'MD', 'MS']),
                    'specialization' => $polyclinic->specialization,
                    'hospital' => $faker->company,
                    'address' => $faker->address,
                    'city' => $faker->city,
                    'province' => $faker->state,
                    'zip' => $faker->postcode,
                    'country' => $faker->country,
                    'photo' => 'default.jpg', // Example photo, you may change this
                    'status' => $faker->randomElement(['Active', 'Inactive']),
                    'polyclinic_id' => $polyclinic->polyID,
                    'is_active' => $faker->randomElement(['Yes', 'No']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
