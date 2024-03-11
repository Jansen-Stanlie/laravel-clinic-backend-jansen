<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polyclinicTypes = [
            [
                'name' => 'General Medicine',
                'description' => 'Polyclinic for general medical consultations.',
                'degree_requirement' => 'Dokter Umum',
                'degree_mapping' => 'Dr'
            ],
            [
                'name' => 'Pediatrics',
                'description' => 'Polyclinic for children\'s healthcare needs.',
                'degree_requirement' => 'Dokter Spesialis Anak',
                'degree_mapping' => 'Sp.A'
            ],
            [
                'name' => 'Dermatology',
                'description' => 'Polyclinic specializing in skin-related conditions.',
                'degree_requirement' => 'Dokter Spesialis Kulit dan Kelamin',
                'degree_mapping' => 'Sp.KK'
            ],
            [
                'name' => 'Ophthalmology',
                'description' => 'Polyclinic focusing on eye care and vision health.',
                'degree_requirement' => 'Dokter Spesialis Mata',
                'degree_mapping' => 'Sp.M'
            ],
            [
                'name' => 'Orthopedics',
                'description' => 'Polyclinic specializing in musculoskeletal conditions and injuries.',
                'degree_requirement' => 'Dokter Spesialis Orthopedi',
                'degree_mapping' => 'Sp.OT'
            ],
            [
                'name' => 'Cardiology',
                'description' => 'Polyclinic specializing in heart-related conditions.',
                'degree_requirement' => 'Dokter Spesialis Jantung dan Pembuluh Darah',
                'degree_mapping' => 'Sp.JP'
            ],
            [
                'name' => 'Obstetrics and Gynecology',
                'description' => 'Polyclinic specializing in women\'s health and childbirth.',
                'degree_requirement' => 'Dokter Spesialis Kandungan dan Kebidanan',
                'degree_mapping' => 'Sp.OG'
            ],
            [
                'name' => 'Dentistry',
                'description' => 'Polyclinic focusing on dental care.',
                'degree_requirement' => 'Dokter Gigi (Drg)',
                'degree_mapping' => 'Drg'
            ],
            [
                'name' => 'ENT (Ear, Nose, and Throat)',
                'description' => 'Polyclinic specializing in ear, nose, and throat conditions.',
                'degree_requirement' => 'Dokter Spesialis THT-KL',
                'degree_mapping' => 'Sp.THT'
            ],
            [
                'name' => 'Psychiatry',
                'description' => 'Polyclinic specializing in mental health.',
                'degree_requirement' => 'Dokter Spesialis Jiwa',
                'degree_mapping' => 'Sp.Jiwa'
            ], [
                'name' => 'General Medicine',
                'description' => 'Polyclinic for general medical consultations.',
                'degree_requirement' => 'Dokter Umum',
                'degree_mapping' => 'Dr'
            ],
            [
                'name' => 'Pediatrics',
                'description' => 'Polyclinic for children\'s healthcare needs.',
                'degree_requirement' => 'Dokter Spesialis Anak',
                'degree_mapping' => 'Sp.A'
            ],
            [
                'name' => 'Dermatology',
                'description' => 'Polyclinic specializing in skin-related conditions.',
                'degree_requirement' => 'Dokter Spesialis Kulit dan Kelamin',
                'degree_mapping' => 'Sp.KK'
            ],
            [
                'name' => 'Ophthalmology',
                'description' => 'Polyclinic focusing on eye care and vision health.',
                'degree_requirement' => 'Dokter Spesialis Mata',
                'degree_mapping' => 'Sp.M'
            ],
            [
                'name' => 'Orthopedics',
                'description' => 'Polyclinic specializing in musculoskeletal conditions and injuries.',
                'degree_requirement' => 'Dokter Spesialis Orthopedi',
                'degree_mapping' => 'Sp.OT'
            ],
            [
                'name' => 'Cardiology',
                'description' => 'Polyclinic specializing in heart-related conditions.',
                'degree_requirement' => 'Dokter Spesialis Jantung dan Pembuluh Darah',
                'degree_mapping' => 'Sp.JP'
            ],
            [
                'name' => 'Obstetrics and Gynecology',
                'description' => 'Polyclinic specializing in women\'s health and childbirth.',
                'degree_requirement' => 'Dokter Spesialis Kandungan dan Kebidanan',
                'degree_mapping' => 'Sp.OG'
            ],
            [
                'name' => 'Dentistry',
                'description' => 'Polyclinic focusing on dental care.',
                'degree_requirement' => 'Dokter Gigi (Drg)',
                'degree_mapping' => 'Drg'
            ],
            [
                'name' => 'ENT (Ear, Nose, and Throat)',
                'description' => 'Polyclinic specializing in ear, nose, and throat conditions.',
                'degree_requirement' => 'Dokter Spesialis THT-KL',
                'degree_mapping' => 'Sp.THT'
            ],
            [
                'name' => 'Psychiatry',
                'description' => 'Polyclinic specializing in mental health.',
                'degree_requirement' => 'Dokter Spesialis Jiwa',
                'degree_mapping' => 'Sp.Jiwa'
            ],
            [
                'name' => 'Neurology',
                'description' => 'Polyclinic specializing in disorders of the nervous system.',
                'degree_requirement' => 'Dokter Spesialis Saraf',
                'degree_mapping' => 'Sp.Saraf'
            ],
            [
                'name' => 'Urology',
                'description' => 'Polyclinic specializing in urinary tract health and urological conditions.',
                'degree_requirement' => 'Dokter Spesialis Urologi',
                'degree_mapping' => 'Sp.U'
            ],
            [
                'name' => 'Endocrinology',
                'description' => 'Polyclinic focusing on hormonal disorders and endocrine system health.',
                'degree_requirement' => 'Dokter Spesialis Endokrinologi',
                'degree_mapping' => 'Sp.Endo'
            ],
            [
                'name' => 'Gastroenterology',
                'description' => 'Polyclinic specializing in digestive system disorders.',
                'degree_requirement' => 'Dokter Spesialis Gastroenterologi',
                'degree_mapping' => 'Sp.GK'
            ],
            [
                'name' => 'Hematology',
                'description' => 'Polyclinic focusing on blood disorders.',
                'degree_requirement' => 'Dokter Spesialis Hematologi',
                'degree_mapping' => 'Sp.Hem'
            ],
            [
                'name' => 'Pulmonology',
                'description' => 'Polyclinic specializing in respiratory system disorders.',
                'degree_requirement' => 'Dokter Spesialis Paru',
                'degree_mapping' => 'Sp.Paru'
            ],
            [
                'name' => 'Radiology',
                'description' => 'Polyclinic specializing in medical imaging and radiological procedures.',
                'degree_requirement' => 'Dokter Spesialis Radiologi',
                'degree_mapping' => 'Sp.Rad'
            ],
            [
                'name' => 'Nephrology',
                'description' => 'Polyclinic focusing on kidney health and kidney-related conditions.',
                'degree_requirement' => 'Dokter Spesialis Nefrologi',
                'degree_mapping' => 'Sp.Nefro'
            ],
            [
                'name' => 'Allergy and Immunology',
                'description' => 'Polyclinic specializing in allergies and immune system disorders.',
                'degree_requirement' => 'Dokter Spesialis Alergi dan Imunologi',
                'degree_mapping' => 'Sp.AI'
            ],
            [
                'name' => 'Rheumatology',
                'description' => 'Polyclinic focusing on musculoskeletal and autoimmune disorders.',
                'degree_requirement' => 'Dokter Spesialis Reumatologi',
                'degree_mapping' => 'Sp.Reum'
            ],
            [
                'name' => 'Oncology',
                'description' => 'Polyclinic specializing in cancer treatment and care.',
                'degree_requirement' => 'Dokter Spesialis Onkologi',
                'degree_mapping' => 'Sp.Onk'
            ],
            // Add more polyclinic types with their respective degree requirements and mappings
        ];

        foreach ($polyclinicTypes as $index => $polyclinic) {
            // Inside this loop, $polyclinic represents each individual polyclinic type

            // Create a new Polyclinic record using the create method
            \App\Models\Polyclinic::create([
                'PolyID' => 'PL' . str_pad($index + 1, 3, '0', STR_PAD_LEFT), // Format PolyID as PL001, PL002, etc.
                'polyName' => $polyclinic['name'],                 // Assign the name of the polyclinic
                'description' => $polyclinic['description'],   // Assign the description of the polyclinic
                'degree_requirement' => $polyclinic['degree_requirement'], // Assign the degree requirement for the polyclinic
                'specialization' => $polyclinic['degree_mapping'], // Assign the degree mapping for the polyclinic

                // You can add more fields here as needed
                // For example, if you have additional fields in your Polyclinic model/table, you can assign them here
                // Example:
                // 'field_name' => $polyclinic['field_value'],
            ]);
        }
    }
}
