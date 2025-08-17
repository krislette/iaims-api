<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // First, clear existing data
        DB::table('tblaudit_areas')->delete();

        // Define the hierarchical audit areas data
        $auditAreas = [
            // Root Level Areas
            [
                'ara_id' => 1,
                'ara_name' => 'Management and Planning',
                'ara_ara_id' => 1,  // Self-reference for root level
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 2,
                'ara_name' => 'Program/Project Management',
                'ara_ara_id' => 2,  // Self-reference for root level
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 3,
                'ara_name' => 'Financial Management',
                'ara_ara_id' => 3,  // Self-reference for root level
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 4,
                'ara_name' => 'Human Resource Management',
                'ara_ara_id' => 4,  // Self-reference for root level
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 5,
                'ara_name' => 'Information Systems',
                'ara_ara_id' => 5,  // Self-reference for root level
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sub-areas for Management and Planning (ara_id = 1)
            [
                'ara_id' => 6,
                'ara_name' => 'R&D Roadmap',
                'ara_ara_id' => 1,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 7,
                'ara_name' => 'Identification and Conceptualization of Programs/Projects',
                'ara_ara_id' => 1,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 8,
                'ara_name' => 'Strategic Planning',
                'ara_ara_id' => 1,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 9,
                'ara_name' => 'Operational Planning',
                'ara_ara_id' => 1,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sub-areas for Program/Project Management (ara_id = 2)
            [
                'ara_id' => 10,
                'ara_name' => 'Small Enterprise Technology Upgrading Program (SETUP)',
                'ara_ara_id' => 2,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 11,
                'ara_name' => 'Technology Transfer and Commercialization',
                'ara_ara_id' => 2,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 12,
                'ara_name' => 'Research and Development Projects',
                'ara_ara_id' => 2,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sub-sub-areas for SETUP (ara_id = 10)
            [
                'ara_id' => 13,
                'ara_name' => 'Technology Needs Assessment',
                'ara_ara_id' => 10,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 14,
                'ara_name' => 'Memorandum of Agreement',
                'ara_ara_id' => 10,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 15,
                'ara_name' => 'Project Monitoring and Evaluation Reports',
                'ara_ara_id' => 10,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 16,
                'ara_name' => 'Grants-in-Aid (GIA) Program',
                'ara_ara_id' => 10,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sub-areas for Financial Management (ara_id = 3)
            [
                'ara_id' => 17,
                'ara_name' => 'Budget Planning and Preparation',
                'ara_ara_id' => 3,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 18,
                'ara_name' => 'Budget Execution',
                'ara_ara_id' => 3,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 19,
                'ara_name' => 'Financial Reporting',
                'ara_ara_id' => 3,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 20,
                'ara_name' => 'Cash Management',
                'ara_ara_id' => 3,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 21,
                'ara_name' => 'Asset Management',
                'ara_ara_id' => 3,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sub-areas for Human Resource Management (ara_id = 4)
            [
                'ara_id' => 22,
                'ara_name' => 'Recruitment and Selection',
                'ara_ara_id' => 4,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 23,
                'ara_name' => 'Performance Management',
                'ara_ara_id' => 4,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 24,
                'ara_name' => 'Training and Development',
                'ara_ara_id' => 4,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 25,
                'ara_name' => 'Employee Benefits and Welfare',
                'ara_ara_id' => 4,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sub-areas for Information Systems (ara_id = 5)
            [
                'ara_id' => 26,
                'ara_name' => 'IT Infrastructure Management',
                'ara_ara_id' => 5,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 27,
                'ara_name' => 'Data Security and Privacy',
                'ara_ara_id' => 5,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 28,
                'ara_name' => 'System Development and Maintenance',
                'ara_ara_id' => 5,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 29,
                'ara_name' => 'Digital Transformation Initiatives',
                'ara_ara_id' => 5,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Some third-level sub-areas
            [
                'ara_id' => 30,
                'ara_name' => 'Network Security Policies',
                'ara_ara_id' => 27,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 31,
                'ara_name' => 'Backup and Recovery Procedures',
                'ara_ara_id' => 27,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ara_id' => 32,
                'ara_name' => 'User Access Controls',
                'ara_ara_id' => 27,
                'ara_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert the data
        DB::table('tblaudit_areas')->insert($auditAreas);

        $this->command->info('Audit Areas seeder completed successfully!');
        $this->command->info('Created ' . count($auditAreas) . ' audit areas with hierarchical structure.');
    }
}
