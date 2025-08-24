<?php

namespace Database\Seeders;

use App\Models\AuditCriteria;
use Illuminate\Database\Seeder;

class AuditCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditCriteria = [
            [
                'cra_id' => 1001,
                'cra_name' => 'Financial Accountability and Transparency',
                'cra_areas' => 'Financial Management',
                'cra_references' => 'RA 6713 - Code of Conduct and Ethical Standards for Public Officials',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1002,
                'cra_name' => 'Procurement Compliance',
                'cra_areas' => 'Procurement',
                'cra_references' => 'RA 9184 - Government Procurement Reform Act',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1003,
                'cra_name' => 'Human Resource Management Standards',
                'cra_areas' => 'Human Resources',
                'cra_references' => 'CSC MC No. 38, s. 2017 - Revised Rules on Administrative Cases',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1004,
                'cra_name' => 'Information Security and Data Privacy',
                'cra_areas' => 'Information Technology',
                'cra_references' => 'RA 10173 - Data Privacy Act, RA 8792 - E-Commerce Act',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1005,
                'cra_name' => 'Budget Planning and Execution',
                'cra_areas' => 'Financial Management',
                'cra_references' => 'PD 1445 - Government Auditing Code of the Philippines',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1006,
                'cra_name' => 'Asset Management and Inventory',
                'cra_areas' => 'Operations Management',
                'cra_references' => 'COA Circular No. 2019-004 - Manual on Property, Plant and Equipment',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1007,
                'cra_name' => 'Environmental and Social Safeguards',
                'cra_areas' => 'Operations Management',
                'cra_references' => 'EO 79 - Creating the Environmental Impact Assessment System',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1008,
                'cra_name' => 'Records Management and Documentation',
                'cra_areas' => 'Information Technology',
                'cra_references' => 'RA 9470 - National Archives Act, NARA Issuances',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1009,
                'cra_name' => 'Performance Management and Evaluation',
                'cra_areas' => 'Human Resources',
                'cra_references' => 'CSC MC No. 06, s. 2017 - Performance Evaluation System',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1010,
                'cra_name' => 'Risk Management and Internal Controls',
                'cra_areas' => 'Operations Management',
                'cra_references' => 'COA Circular No. 2009-006 - Internal Control Standards',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1011,
                'cra_name' => 'Public Service Delivery Standards',
                'cra_areas' => 'Operations Management',
                'cra_references' => 'RA 11032 - Ease of Doing Business Act, CC-2018-001',
                'cra_active' => 1,
            ],
            [
                'cra_id' => 1012,
                'cra_name' => 'Contract Management and Monitoring',
                'cra_areas' => 'Procurement',
                'cra_references' => 'IRR of RA 9184, GPPB Resolution No. 09-2020',
                'cra_active' => 1,
            ],
        ];

        foreach ($auditCriteria as $criteriaData) {
            AuditCriteria::create($criteriaData);
        }

        $this->command->info('Audit Criteria seeder completed successfully!');
    }
}
