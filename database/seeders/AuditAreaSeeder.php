<?php

namespace Database\Seeders;

use App\Models\AuditArea;
use Illuminate\Database\Seeder;

class AuditAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditAreas = [
            // Parent audit areas (no parent)
            [
                'ara_id' => 1,
                'ara_name' => 'Financial Management',
                'ara_ara_id' => null,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 2,
                'ara_name' => 'Human Resources',
                'ara_ara_id' => null,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 3,
                'ara_name' => 'Information Technology',
                'ara_ara_id' => null,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 4,
                'ara_name' => 'Operations Management',
                'ara_ara_id' => null,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 5,
                'ara_name' => 'Procurement',
                'ara_ara_id' => null,
                'ara_active' => 1,
            ],
            // Child audit areas under Financial Management (ara_id = 1)
            [
                'ara_id' => 10,
                'ara_name' => 'Budget Planning',
                'ara_ara_id' => 1,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 11,
                'ara_name' => 'Revenue Management',
                'ara_ara_id' => 1,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 12,
                'ara_name' => 'Expense Management',
                'ara_ara_id' => 1,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 13,
                'ara_name' => 'Financial Reporting',
                'ara_ara_id' => 1,
                'ara_active' => 1,
            ],
            // Child audit areas under Human Resources (ara_id = 2)
            [
                'ara_id' => 20,
                'ara_name' => 'Recruitment and Selection',
                'ara_ara_id' => 2,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 21,
                'ara_name' => 'Performance Management',
                'ara_ara_id' => 2,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 22,
                'ara_name' => 'Training and Development',
                'ara_ara_id' => 2,
                'ara_active' => 1,
            ],
            // Child audit areas under Information Technology (ara_id = 3)
            [
                'ara_id' => 30,
                'ara_name' => 'System Security',
                'ara_ara_id' => 3,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 31,
                'ara_name' => 'Data Management',
                'ara_ara_id' => 3,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 32,
                'ara_name' => 'System Development',
                'ara_ara_id' => 3,
                'ara_active' => 1,
            ],
            // Child audit areas under Procurement (ara_id = 5)
            [
                'ara_id' => 50,
                'ara_name' => 'Supplier Management',
                'ara_ara_id' => 5,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 51,
                'ara_name' => 'Contract Management',
                'ara_ara_id' => 5,
                'ara_active' => 1,
            ],
            // Sub-child example under Budget Planning (ara_id = 10)
            [
                'ara_id' => 100,
                'ara_name' => 'Annual Budget Preparation',
                'ara_ara_id' => 10,
                'ara_active' => 1,
            ],
            [
                'ara_id' => 101,
                'ara_name' => 'Budget Monitoring and Control',
                'ara_ara_id' => 10,
                'ara_active' => 1,
            ],
        ];

        foreach ($auditAreas as $auditAreaData) {
            AuditArea::create($auditAreaData);
        }

        $this->command->info('Audit Area seeder completed successfully!');
    }
}
