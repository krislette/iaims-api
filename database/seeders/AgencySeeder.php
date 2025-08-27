<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, let's seed some agency groupings if they don't exist
        $groupings = [
            ['agn_grp_code' => 'CO', 'agn_grp_name' => 'CO - DOST-CO'],
            ['agn_grp_code' => 'SC', 'agn_grp_name' => 'SC - Sectorial Planning Council'],
            ['agn_grp_code' => 'CB', 'agn_grp_name' => 'CB - College Bodies'],
            ['agn_grp_code' => 'RD', 'agn_grp_name' => 'RD - Research and Development Institutes'],
            ['agn_grp_code' => 'ST', 'agn_grp_name' => 'ST - Scientific and Technical Service Institutes'],
            ['agn_grp_code' => 'RO', 'agn_grp_name' => 'RO - Regional Offices'],
        ];

        foreach ($groupings as $grouping) {
            DB::table('tblagency_groupings')->updateOrInsert(
                ['agn_grp_code' => $grouping['agn_grp_code']],
                $grouping
            );
        }

        // Sample agencies data
        $agencies = [
            [
                'agn_id' => 1001,
                'agn_name' => 'Department of Science and Technology',
                'agn_acronym' => 'DOST',
                'agn_grp_code' => 'CO',
                'agn_address' => 'DOST Compound, General Santos Ave., Bicutan, Taguig City',
                'agn_head_name' => 'Renato U. Solidum Jr.',
                'agn_head_position' => 'Secretary',
                'agn_contact_details' => 'Tel: (02) 8837-2071 to 82' . PHP_EOL . 'Email: info@dost.gov.ph' . PHP_EOL . 'Website: www.dost.gov.ph',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'agn_id' => 1002,
                'agn_name' => 'Department of Education',
                'agn_acronym' => 'DepEd',
                'agn_grp_code' => 'CO',
                'agn_address' => 'DepEd Complex, Meralco Avenue, Pasig City',
                'agn_head_name' => 'Sara Z. Duterte',
                'agn_head_position' => 'Secretary',
                'agn_contact_details' => 'Tel: (02) 8631-1361 to 65' . PHP_EOL . 'Email: info@deped.gov.ph' . PHP_EOL . 'Website: www.deped.gov.ph',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'agn_id' => 1003,
                'agn_name' => 'Commission on Audit',
                'agn_acronym' => 'COA',
                'agn_grp_code' => 'SC',
                'agn_address' => 'Commonwealth Avenue, Quezon City',
                'agn_head_name' => 'Gamaliel A. Cordoba',
                'agn_head_position' => 'Chairperson',
                'agn_contact_details' => 'Tel: (02) 8951-4985' . PHP_EOL . 'Email: info@coa.gov.ph' . PHP_EOL . 'Website: www.coa.gov.ph',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'agn_id' => 1004,
                'agn_name' => 'University of the Philippines',
                'agn_acronym' => 'UP',
                'agn_grp_code' => 'CB',
                'agn_address' => 'Diliman, Quezon City',
                'agn_head_name' => 'Angelo A. Jimenez',
                'agn_head_position' => 'President',
                'agn_contact_details' => 'Tel: (02) 8981-8500' . PHP_EOL . 'Email: info@up.edu.ph' . PHP_EOL . 'Website: www.up.edu.ph',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'agn_id' => 1005,
                'agn_name' => 'Social Security System',
                'agn_acronym' => 'SSS',
                'agn_grp_code' => 'SC',
                'agn_address' => 'SSS Building, East Avenue, Diliman, Quezon City',
                'agn_head_name' => 'Michael G. Regino',
                'agn_head_position' => 'President and CEO',
                'agn_contact_details' => 'Tel: (02) 8920-6401' . PHP_EOL . 'Email: member_relations@sss.gov.ph' . PHP_EOL . 'Website: www.sss.gov.ph',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($agencies as $agency) {
            DB::table('tblagencies')->updateOrInsert(
                ['agn_id' => $agency['agn_id']],
                $agency
            );
        }
    }
}
