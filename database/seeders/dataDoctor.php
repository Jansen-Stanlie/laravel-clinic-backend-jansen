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
                // Generate unique doctor_id
                $doctorId = $this->generateDoctorId();

                Doctor::create([
                    'doctor_id' => $doctorId,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'password' => bcrypt('password'), // Example password, you may change this
                    'role' => 'Doctor',
                    'degree' => $polyclinic->specialization,
                    'specialization' => $polyclinic->degree_requirement,
                    'hospital' => $faker->company,
                    'address' => $faker->address,
                    'city' => $faker->city,
                    'province' => $faker->state,
                    'zip' => $faker->postcode,
                    'country' => $faker->country,
                    'photo' => $faker->imageUrl(), // Example photo, you may change this
                    'status' => $faker->randomElement(['Active', 'Inactive']),
                    'polyName' => $polyclinic->polyName, // Add polyName data
                    'polyclinic_id' => $polyclinic->polyID,
                    'is_active' => $faker->randomElement(['Yes', 'No']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Generate unique doctor_id.
     *
     * @return string
     */
    private function generateDoctorId()
    {
        $prefix = 'DCR';
        $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $randomCharacters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
        return $prefix . $randomNumber . $randomCharacters;
    }
}
