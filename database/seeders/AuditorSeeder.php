<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Auditor;
use Illuminate\Database\Seeder;

class AuditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first agency ID for reference (assuming agencies are already seeded)
        $firstAgency = Agency::first();

        if (!$firstAgency) {
            $this->command->warn('No agencies found. Please seed agencies first.');
            return;
        }

        $auditors = [
            [
                'aur_id' => 1001,
                'aur_name_last' => 'Cruz',
                'aur_name_first' => 'Juan',
                'aur_name_middle' => 'Santos',
                'aur_name_prefix' => 'Mr.',
                'aur_name_suffix' => 'Jr.',
                'aur_external' => 0,
                'aur_position' => 'Senior Auditor',
                'aur_salary_grade' => 24,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Financial Auditing, Risk Assessment',
                'aur_email' => 'j.cruz@example.gov.ph',
                'aur_birthdate' => '1985-03-15',
                'aur_contact_no' => '+639171234567',
                'aur_tin' => '123456789012',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1001.jpg',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1002,
                'aur_name_last' => 'Reyes',
                'aur_name_first' => 'Maria',
                'aur_name_middle' => 'Garcia',
                'aur_name_prefix' => 'Ms.',
                'aur_name_suffix' => '',
                'aur_external' => 1,
                'aur_position' => 'External Auditor',
                'aur_salary_grade' => 22,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Compliance Auditing, IT Auditing',
                'aur_email' => 'm.reyes@external-audit.com',
                'aur_birthdate' => '1988-07-22',
                'aur_contact_no' => '+639189876543',
                'aur_tin' => '987654321098',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1002.jpg',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1003,
                'aur_name_last' => 'Dela Cruz',
                'aur_name_first' => 'Roberto',
                'aur_name_middle' => 'Mendoza',
                'aur_name_prefix' => 'Dr.',
                'aur_name_suffix' => 'Sr.',
                'aur_external' => 0,
                'aur_position' => 'Chief Auditor',
                'aur_salary_grade' => 26,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Government Auditing, Performance Auditing',
                'aur_email' => 'r.delacruz@example.gov.ph',
                'aur_birthdate' => '1975-11-08',
                'aur_contact_no' => '+639123456789',
                'aur_tin' => '456789123456',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1003.jpg',
                'aur_active' => 1,
            ],
        ];

        foreach ($auditors as $auditorData) {
            Auditor::create($auditorData);
        }

        $this->command->info('Auditor seeder completed successfully!');
    }
}
