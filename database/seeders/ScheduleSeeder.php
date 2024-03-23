<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Doctor;
use Faker\Factory as Faker;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define the months for scheduling
        $startMonth = 'April';
        $endMonth = 'August';

        // Get all doctors
        $doctors = Doctor::all();

        // Loop through each doctor
        foreach ($doctors as $doctor) {
            // Get the polyclinic where the doctor serves
            $polyclinic = $doctor->polyclinic;

            // Create start and end dates as DateTime objects
            $startDate = new \DateTime("first day of $startMonth 2024");
            $endDate = new \DateTime("last day of $endMonth 2024");

            // Loop through each day between start and end dates
            $interval = new \DateInterval('P1D');
            $dateRange = new \DatePeriod($startDate, $interval, $endDate);
            foreach ($dateRange as $date) {
                $dateSchedule = $date->format('Y-m-d'); // Format date as Y-m-d
                $dayName = $date->format('l'); // Get day name (e.g., Monday, Tuesday)

                // Generate a random start time in the morning (between 8 AM, 9 AM, and 10 AM)
                $startTimeHour = $faker->randomElement([8, 9, 10]); // Hour part of the start time
                $startTimeMinute = $faker->numberBetween(0, 59); // Minute part of the start time

                // Calculate end time (8 hours from start)
                $endTimeHour = $startTimeHour + 8;

                // Ensure hour part of end time doesn't exceed 23
                if ($endTimeHour > 23) {
                    $endTimeHour = 23;
                }

                // Create a schedule entry
                Schedule::create([
                    'doctor_id' => $doctor->doctor_id,
                    'polyclinic_id' => $doctor->polyclinic_id, // Assign the correct polyclinic ID
                    'doctor_name' => $doctor->name,
                    'date_schedule' => $dateSchedule,
                    'specialization' => $doctor->specialization, // Assign the correct specialization
                    'day' => $dayName,
                    'start' => sprintf('%02d:%02d:00', $startTimeHour, $startTimeMinute), // Format the start time
                    'end' => sprintf('%02d:00:00', $endTimeHour), // Format the end time
                    'status' => $faker->randomElement(['available', 'booked']),
                ]);
            }
        }
    }
}
