<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Polyclinic;
use Faker\Factory as Faker;
use App\Services\UnsplashService;

class dataDoctor extends Seeder
{
    protected $unsplashService;

    public function __construct(UnsplashService $unsplashService)
    {
        $this->unsplashService = $unsplashService;
    }
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
            $numDoctors = $faker->numberBetween(1, 10);

            for ($i = 0; $i < $numDoctors; $i++) {
                // Generate unique doctor_id
                $doctorId = $this->generateDoctorId();

                $photo = $this->unsplashService->getRandomPersonPhoto();
                // Generate unique nik
                $nik = $this->generateNik();
                // Generate unique sip
                $sip = $this->generateSip();

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
                    'photo' => $photo, // Example photo, you may change this
                    'status' => $faker->randomElement(['Active', 'Inactive']),
                    'polyName' => $polyclinic->polyName, // Add polyName data
                    'polyclinic_id' => $polyclinic->polyID,
                    'is_active' => $faker->randomElement(['Yes', 'No']),
                    'nik' => $nik,
                    'sip' => $sip,
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

    /**
     * Generate unique 16-digit nik.
     *
     * @return string
     */
    private function generateNik()
    {
        // Generate a random 16-digit number
        return str_pad(mt_rand(1, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }
    /**
     * Generate unique sip.
     *
     * @return string
     */
    private function generateSip()
    {
        // Generate unique sip logic here
        $faker  = Faker::create();

        // Generate random numbers for numeric parts
        $numericPart1 = $faker->randomNumber(5);
        $numericPart2 = $faker->randomNumber(5);
        $numericPart3 = $faker->randomNumber(2);
        $numericPart4 = $faker->randomFloat(1, 1, 999); // For example, generate a random number between 1 and 999 with 1 decimal place
        $numericPart5 = $faker->randomNumber(3);

        // Generate a random year
        $year = $faker->year();

        // Generate a random month in Roman numeral
        $month = $faker->numberBetween(1, 12);
        $romanMonth = $this->convertToRoman($month);

        // Construct the SIP string
        $sip = sprintf('%05d-%05d/DU.%04d/%.1f/%.1f/%03d/%s/%d', $numericPart1, $numericPart2, $year, $numericPart3, $numericPart4, $numericPart5, $romanMonth, $year);

        return $sip;
    }

    /**
     * Convert number to Roman numeral.
     *
     * @param int $number
     * @return string
     */
    private function convertToRoman($number)
    {
        $roman = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            20 => 'XX', 30 => 'XXX', 40 => 'XL', 50 => 'L', 60 => 'LX', 70 => 'LXX', 80 => 'LXXX', 90 => 'XC', 100 => 'C',
            200 => 'CC', 300 => 'CCC', 400 => 'CD', 500 => 'D', 600 => 'DC', 700 => 'DCC', 800 => 'DCCC', 900 => 'CM', 1000 => 'M'
        ];

        $result = '';
        foreach (array_reverse(array_keys($roman)) as $value) {
            while ($number >= $value) {
                $result .= $roman[$value];
                $number -= $value;
            }
        }
        return $result;
    }
}
