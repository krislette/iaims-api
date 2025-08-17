<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Auditor;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AuditorSeeder extends Seeder
{
    public function run(): void
    {
        // Clear table first to avoid duplicate primary keys
        \DB::table('tblauditors')->delete();

        $faker = Faker::create();
        $agencies = Agency::take(5)->get();
        $defaultAgencyId = $agencies->first()?->agn_id ?? 1;  // Fallback

        $expertiseAreas = [
            'Financial Audit',
            'Performance Audit',
            'Compliance Audit',
            'IT Audit',
            'Environmental Audit',
            'Procurement Audit',
            'Risk Management',
            'Internal Controls',
            'Fraud Investigation',
            'Management Systems',
        ];

        $statuses = [1, 0];  // 1 = Active, 0 = Inactive

        $auditors = [
            [
                'aur_id' => 1001,
                'aur_name_last' => 'Cruz',
                'aur_name_first' => 'Maria Elena',
                'aur_name_middle' => 'Santos',
                'aur_name_prefix' => '',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Senior Auditor',
                'aur_salary_grade' => 18,
                'aur_agn_id' => $defaultAgencyId,
                'aur_expertise' => 'Financial Audit, IT Audit',
                'aur_email' => 'maria.cruz@dost.gov.ph',
                'aur_birthdate' => '1985-03-15',
                'aur_contact_no' => '+63 917 123 4567',
                'aur_tin' => '123456789000',
                'aur_status' => 1,
                'aur_photo' => 'default.png',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1002,
                'aur_name_last' => 'Reyes',
                'aur_name_first' => 'Juan Carlos',
                'aur_name_middle' => 'Mendoza',
                'aur_name_prefix' => '',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Lead Auditor',
                'aur_salary_grade' => 20,
                'aur_agn_id' => $defaultAgencyId,
                'aur_expertise' => 'Performance Audit, Compliance Audit',
                'aur_email' => 'juan.reyes@coa.gov.ph',
                'aur_birthdate' => '1982-07-22',
                'aur_contact_no' => '+63 918 987 6543',
                'aur_tin' => '234567890111',
                'aur_status' => 1,
                'aur_photo' => 'default.png',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1003,
                'aur_name_last' => 'Santos',
                'aur_name_first' => 'Ana Beatriz',
                'aur_name_middle' => 'Dela Cruz',
                'aur_name_prefix' => '',
                'aur_name_suffix' => '',
                'aur_external' => 1,
                'aur_position' => 'External Auditor',
                'aur_salary_grade' => 16,
                'aur_agn_id' => $defaultAgencyId,
                'aur_expertise' => 'Financial Audit, Risk Management',
                'aur_email' => 'ana.santos@sgv.ph',
                'aur_birthdate' => '1990-11-08',
                'aur_contact_no' => '+63 919 456 7890',
                'aur_tin' => '345678901222',
                'aur_status' => 1,
                'aur_photo' => 'default.png',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1004,
                'aur_name_last' => 'Garcia',
                'aur_name_first' => 'Roberto Miguel',
                'aur_name_middle' => 'Torres',
                'aur_name_prefix' => '',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Environmental Auditor',
                'aur_salary_grade' => 16,
                'aur_agn_id' => $defaultAgencyId,
                'aur_expertise' => 'Environmental Audit, Compliance Audit',
                'aur_email' => 'roberto.garcia@denr.gov.ph',
                'aur_birthdate' => '1987-04-30',
                'aur_contact_no' => '+63 920 234 5678',
                'aur_tin' => '456789012333',
                'aur_status' => 1,
                'aur_photo' => 'default.png',
                'aur_active' => 1,
            ],
        ];

        foreach ($auditors as $auditorData) {
            Auditor::create($auditorData);
        }

        // Generate random auditors
        for ($i = 1009; $i <= 1020; $i++) {
            $isInternal = $faker->boolean(70);
            $agencyId = $isInternal && $agencies->isNotEmpty()
                ? $faker->randomElement($agencies)->agn_id
                : $defaultAgencyId;

            Auditor::create([
                'aur_id' => $i,
                'aur_name_last' => $faker->lastName,
                'aur_name_first' => $faker->firstName,
                'aur_name_middle' => $faker->lastName,
                'aur_name_prefix' => '',
                'aur_name_suffix' => '',
                'aur_external' => $isInternal ? 0 : 1,
                'aur_position' => $faker->randomElement([
                    'Senior Auditor', 'Lead Auditor', 'Audit Manager',
                    'External Auditor', 'Junior Auditor', 'Audit Supervisor'
                ]),
                'aur_salary_grade' => $isInternal ? $faker->numberBetween(12, 24) : 12,
                'aur_agn_id' => $agencyId,
                'aur_expertise' => implode(', ', $faker->randomElements($expertiseAreas, rand(1, 3))),
                'aur_email' => $faker->email,
                'aur_birthdate' => $faker->dateTimeBetween('-45 years', '-25 years')->format('Y-m-d'),
                'aur_contact_no' => $faker->phoneNumber,
                'aur_tin' => $faker->numerify('##########'),
                'aur_status' => $faker->randomElement($statuses),
                'aur_photo' => 'default.png',
                'aur_active' => 1,
            ]);
        }
    }
}
