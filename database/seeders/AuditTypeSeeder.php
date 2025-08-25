<?php

namespace Database\Seeders;

use App\Models\AuditType;
use Illuminate\Database\Seeder;

class AuditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditTypes = [
            [
                'aud_typ_id' => 1,
                'aud_typ_name' => 'Financial Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 2,
                'aud_typ_name' => 'Performance Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 3,
                'aud_typ_name' => 'Compliance Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 4,
                'aud_typ_name' => 'IT Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 5,
                'aud_typ_name' => 'Operational Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 6,
                'aud_typ_name' => 'Internal Control Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 7,
                'aud_typ_name' => 'Special Investigation',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 8,
                'aud_typ_name' => 'Management Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 9,
                'aud_typ_name' => 'Environmental Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 10,
                'aud_typ_name' => 'Procurement Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 11,
                'aud_typ_name' => 'Contract Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 12,
                'aud_typ_name' => 'Revenue Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 13,
                'aud_typ_name' => 'Payroll Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 14,
                'aud_typ_name' => 'Inventory Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 15,
                'aud_typ_name' => 'Cash Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 16,
                'aud_typ_name' => 'Pre-Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 17,
                'aud_typ_name' => 'Post-Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 18,
                'aud_typ_name' => 'Follow-up Audit',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 19,
                'aud_typ_name' => 'Risk Assessment',
                'aud_typ_active' => 1,
            ],
            [
                'aud_typ_id' => 20,
                'aud_typ_name' => 'Fraud Investigation',
                'aud_typ_active' => 1,
            ],
        ];

        foreach ($auditTypes as $auditTypeData) {
            AuditType::create($auditTypeData);
        }

        $this->command->info('Audit Type seeder completed successfully!');
    }
}
