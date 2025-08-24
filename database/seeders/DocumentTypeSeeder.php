<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            [
                'doc_typ_id' => 1,
                'doc_typ_name' => 'Audit Report',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 2,
                'doc_typ_name' => 'Working Papers',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 3,
                'doc_typ_name' => 'Management Letter',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 4,
                'doc_typ_name' => 'Audit Program',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 5,
                'doc_typ_name' => 'Risk Assessment',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 6,
                'doc_typ_name' => 'Internal Control Evaluation',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 7,
                'doc_typ_name' => 'Compliance Testing',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 8,
                'doc_typ_name' => 'Substantive Testing',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 9,
                'doc_typ_name' => 'Engagement Letter',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 10,
                'doc_typ_name' => 'Exit Conference Minutes',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 11,
                'doc_typ_name' => 'Audit Checklist',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 12,
                'doc_typ_name' => 'Financial Statements',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 13,
                'doc_typ_name' => 'Supporting Documents',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 14,
                'doc_typ_name' => 'Corrective Action Plan',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 15,
                'doc_typ_name' => 'Follow-up Report',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 16,
                'doc_typ_name' => 'Interim Report',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 17,
                'doc_typ_name' => 'Special Investigation Report',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 18,
                'doc_typ_name' => 'Performance Audit Report',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 19,
                'doc_typ_name' => 'IT Audit Report',
                'doc_typ_active' => 1,
            ],
            [
                'doc_typ_id' => 20,
                'doc_typ_name' => 'Memorandum',
                'doc_typ_active' => 1,
            ],
        ];

        foreach ($documentTypes as $documentTypeData) {
            DocumentType::create($documentTypeData);
        }

        $this->command->info('Document Type seeder completed successfully!');
    }
}
