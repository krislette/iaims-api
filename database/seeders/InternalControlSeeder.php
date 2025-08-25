<?php

namespace Database\Seeders;

use App\Models\AuditArea;
use App\Models\InternalControl;
use App\Models\InternalControlComponent;
use Illuminate\Database\Seeder;

class InternalControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first audit area for reference (assuming audit areas are already seeded)
        $auditAreas = AuditArea::take(3)->get();

        if ($auditAreas->isEmpty()) {
            $this->command->warn('No audit areas found. Please seed audit areas first.');
            return;
        }

        $internalControls = [
            [
                'ic_id' => 2001,
                'ic_ara_id' => $auditAreas[0]->ara_id,
                'ic_category' => 'Authorization Controls',
                'ic_desc' => 'Controls to ensure that all transactions and activities are properly authorized by appropriate personnel before execution.',
                'ic_active' => 1,
                'components' => [
                    ['com_seqnum' => 1, 'com_desc' => 'Segregation of duties between authorization, recording, and custody functions'],
                    ['com_seqnum' => 2, 'com_desc' => 'Approval matrix defining authorization levels for different transaction types'],
                    ['com_seqnum' => 3, 'com_desc' => 'Documentation requirements for all authorized transactions'],
                ]
            ],
            [
                'ic_id' => 2002,
                'ic_ara_id' => $auditAreas[1]->ara_id,
                'ic_category' => 'Documentation Controls',
                'ic_desc' => 'Controls to ensure adequate documentation and record-keeping for all significant transactions and activities.',
                'ic_active' => 1,
                'components' => [
                    ['com_seqnum' => 1, 'com_desc' => 'Standardized forms and templates for recording transactions'],
                    ['com_seqnum' => 2, 'com_desc' => 'Sequential numbering system for all transaction documents'],
                    ['com_seqnum' => 3, 'com_desc' => 'Electronic backup and storage of critical documents'],
                ]
            ],
            [
                'ic_id' => 2003,
                'ic_ara_id' => count($auditAreas) > 1 ? $auditAreas[1]->ara_id : $auditAreas[0]->ara_id,
                'ic_category' => 'Reconciliation Controls',
                'ic_desc' => 'Controls to ensure accuracy and completeness of financial and operational data through regular reconciliations.',
                'ic_active' => 1,
                'components' => [
                    ['com_seqnum' => 1, 'com_desc' => 'Monthly bank reconciliations performed by independent staff'],
                    ['com_seqnum' => 2, 'com_desc' => 'Subsidiary ledger to general ledger reconciliations'],
                    ['com_seqnum' => 3, 'com_desc' => 'Physical inventory counts and reconciliation to perpetual records'],
                ]
            ],
            [
                'ic_id' => 2004,
                'ic_ara_id' => count($auditAreas) > 1 ? $auditAreas[1]->ara_id : $auditAreas[0]->ara_id,
                'ic_category' => 'Access Controls',
                'ic_desc' => 'Controls to restrict access to assets, records, and systems to authorized personnel only.',
                'ic_active' => 1,
                'components' => [
                    ['com_seqnum' => 1, 'com_desc' => 'User access management system with role-based permissions'],
                    ['com_seqnum' => 2, 'com_desc' => 'Physical security measures for assets and sensitive areas'],
                    ['com_seqnum' => 3, 'com_desc' => 'Regular review and update of access rights and permissions'],
                ]
            ],
            [
                'ic_id' => 2005,
                'ic_ara_id' => count($auditAreas) > 2 ? $auditAreas[2]->ara_id : $auditAreas[0]->ara_id,
                'ic_category' => 'Performance Monitoring',
                'ic_desc' => 'Controls to monitor and evaluate the effectiveness and efficiency of operations and processes.',
                'ic_active' => 1,
                'components' => [
                    ['com_seqnum' => 1, 'com_desc' => 'Key performance indicators (KPIs) monitoring and reporting'],
                    ['com_seqnum' => 2, 'com_desc' => 'Regular management review of operational metrics'],
                    ['com_seqnum' => 3, 'com_desc' => 'Exception reporting for unusual or significant variances'],
                ]
            ],
            [
                'ic_id' => 2006,
                'ic_ara_id' => count($auditAreas) > 2 ? $auditAreas[2]->ara_id : $auditAreas[0]->ara_id,
                'ic_category' => 'IT General Controls',
                'ic_desc' => 'Controls over IT infrastructure, security, and change management to ensure reliable information processing.',
                'ic_active' => 1,
                'components' => [
                    ['com_seqnum' => 1, 'com_desc' => 'Regular backup and disaster recovery procedures'],
                    ['com_seqnum' => 2, 'com_desc' => 'Change management process for system modifications'],
                    ['com_seqnum' => 3, 'com_desc' => 'Network security monitoring and intrusion detection'],
                ]
            ],
        ];

        foreach ($internalControls as $controlData) {
            $components = $controlData['components'];
            unset($controlData['components']);

            // Create the internal control
            $internalControl = InternalControl::create($controlData);

            // Create the components
            foreach ($components as $componentData) {
                InternalControlComponent::create([
                    'com_ic_id' => $internalControl->ic_id,
                    'com_seqnum' => $componentData['com_seqnum'],
                    'com_desc' => $componentData['com_desc'],
                ]);
            }
        }

        $this->command->info('Internal Control seeder completed successfully!');
    }
}
