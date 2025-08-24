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
            [
                'aur_id' => 1004,
                'aur_name_last' => 'Santos',
                'aur_name_first' => 'Ana',
                'aur_name_middle' => 'Lopez',
                'aur_name_prefix' => 'Ms.',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Audit Manager',
                'aur_salary_grade' => 25,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Management Auditing, Process Improvement',
                'aur_email' => 'a.santos@example.gov.ph',
                'aur_birthdate' => '1980-05-12',
                'aur_contact_no' => '+639167890123',
                'aur_tin' => '234567890123',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1004.jpg',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1005,
                'aur_name_last' => 'Gonzales',
                'aur_name_first' => 'Miguel',
                'aur_name_middle' => 'Ramos',
                'aur_name_prefix' => 'Mr.',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Audit Supervisor',
                'aur_salary_grade' => 23,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Operational Auditing, Team Leadership',
                'aur_email' => 'm.gonzales@example.gov.ph',
                'aur_birthdate' => '1987-09-30',
                'aur_contact_no' => '+639156789012',
                'aur_tin' => '345678901234',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1005.jpg',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1006,
                'aur_name_last' => 'Torres',
                'aur_name_first' => 'Carmen',
                'aur_name_middle' => 'Flores',
                'aur_name_prefix' => 'Mrs.',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Senior Auditor',
                'aur_salary_grade' => 21,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Financial Analysis, Budget Review',
                'aur_email' => 'c.torres@example.gov.ph',
                'aur_birthdate' => '1990-01-18',
                'aur_contact_no' => '+639145678901',
                'aur_tin' => '456789012345',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1006.jpg',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1007,
                'aur_name_last' => 'Mendoza',
                'aur_name_first' => 'Paolo',
                'aur_name_middle' => 'Cruz',
                'aur_name_prefix' => 'Mr.',
                'aur_name_suffix' => '',
                'aur_external' => 0,
                'aur_position' => 'Junior Auditor',
                'aur_salary_grade' => 18,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'Documentation Review, Data Analysis',
                'aur_email' => 'p.mendoza@example.gov.ph',
                'aur_birthdate' => '1993-06-25',
                'aur_contact_no' => '+639134567890',
                'aur_tin' => '567890123456',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1007.jpg',
                'aur_active' => 1,
            ],
            [
                'aur_id' => 1008,
                'aur_name_last' => 'Villanueva',
                'aur_name_first' => 'Lisa',
                'aur_name_middle' => 'Morales',
                'aur_name_prefix' => 'Ms.',
                'aur_name_suffix' => '',
                'aur_external' => 1,
                'aur_position' => 'External Consultant',
                'aur_salary_grade' => 20,
                'aur_agn_id' => $firstAgency->agn_id,
                'aur_expertise' => 'System Analysis, Report Writing',
                'aur_email' => 'l.villanueva@consulting.com',
                'aur_birthdate' => '1992-12-03',
                'aur_contact_no' => '+639123456780',
                'aur_tin' => '678901234567',
                'aur_status' => 1,
                'aur_photo' => 'photos/auditor_1008.jpg',
                'aur_active' => 1,
            ],
        ];

        foreach ($auditors as $auditorData) {
            Auditor::create($auditorData);
        }

        $this->command->info('Auditor seeder completed successfully!');
        $this->command->info('Created 8 auditors with IDs: 1001-1008');
    }
}
