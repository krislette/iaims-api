<?php

namespace Database\Seeders;

use App\Models\Auditor;
use App\Models\UserAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get auditors for reference (assuming auditors are already seeded)
        $auditors = Auditor::take(5)->get();

        if ($auditors->isEmpty()) {
            $this->command->warn('No auditors found. Please seed auditors first.');
            return;
        }

        $userAccounts = [
            [
                'usr_id' => 5001,
                'usr_name' => 'System Administrator',
                'usr_aur_id' => $auditors[0]->aur_id,
                'usr_level' => 1,  // System Administrator
                'usr_email' => 'admin@iaims.gov.ph',
                'usr_password' => Hash::make('admin123'),  // Using direct hash since mutator might not work in seeder
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5002,
                'usr_name' => 'Internal Auditor - Senior',
                'usr_aur_id' => count($auditors) > 1 ? $auditors[1]->aur_id : $auditors[0]->aur_id,
                'usr_level' => 2,  // Internal Auditor
                'usr_email' => 'internal.senior@iaims.gov.ph',
                'usr_password' => Hash::make('auditor123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5003,
                'usr_name' => 'External Auditor',
                'usr_aur_id' => count($auditors) > 2 ? $auditors[2]->aur_id : $auditors[0]->aur_id,
                'usr_level' => 3,  // External Auditor
                'usr_email' => 'external@audit-firm.com',
                'usr_password' => Hash::make('external123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5004,
                'usr_name' => 'Audit Manager',
                'usr_aur_id' => count($auditors) > 3 ? $auditors[3]->aur_id : $auditors[0]->aur_id,
                'usr_level' => 4,  // Audit Manager
                'usr_email' => 'manager@iaims.gov.ph',
                'usr_password' => Hash::make('manager123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5005,
                'usr_name' => 'Audit Supervisor',
                'usr_aur_id' => count($auditors) > 4 ? $auditors[4]->aur_id : $auditors[0]->aur_id,
                'usr_level' => 5,  // Audit Supervisor
                'usr_email' => 'supervisor@iaims.gov.ph',
                'usr_password' => Hash::make('supervisor123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5006,
                'usr_name' => 'Senior Auditor',
                'usr_aur_id' => $auditors[0]->aur_id,
                'usr_level' => 6,  // Senior Auditor
                'usr_email' => 'senior.auditor@iaims.gov.ph',
                'usr_password' => Hash::make('senior123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5007,
                'usr_name' => 'Junior Auditor',
                'usr_aur_id' => count($auditors) > 1 ? $auditors[1]->aur_id : $auditors[0]->aur_id,
                'usr_level' => 7,  // Junior Auditor
                'usr_email' => 'junior.auditor@iaims.gov.ph',
                'usr_password' => Hash::make('junior123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
            [
                'usr_id' => 5008,
                'usr_name' => 'Read Only User',
                'usr_aur_id' => count($auditors) > 2 ? $auditors[2]->aur_id : $auditors[0]->aur_id,
                'usr_level' => 8,  // Read Only User
                'usr_email' => 'readonly@iaims.gov.ph',
                'usr_password' => Hash::make('readonly123'),
                'usr_active' => 1,
                'usr_logged' => 0,
            ],
        ];

        foreach ($userAccounts as $userAccountData) {
            UserAccount::create($userAccountData);
        }

        $this->command->info('User Account seeder completed successfully!');
        $this->command->info('Default passwords:');
        $this->command->info('- System Admin: admin123');
        $this->command->info('- Internal Auditor: auditor123');
        $this->command->info('- External Auditor: external123');
        $this->command->info('- Audit Manager: manager123');
        $this->command->info('- Audit Supervisor: supervisor123');
        $this->command->info('- Senior Auditor: senior123');
        $this->command->info('- Junior Auditor: junior123');
        $this->command->info('- Read Only User: readonly123');
    }
}
