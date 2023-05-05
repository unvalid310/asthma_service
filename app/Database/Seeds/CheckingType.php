<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CheckingType extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'checking_type' => 'After Waking Up',
            ],
            [
                'id' => 2,
                'checking_type' => '1-2 Hours After Breakfast',
            ],
            [
                'id' => 3,
                'checking_type' => 'Before Lunch',
            ],
            [
                'id' => 4,
                'checking_type' => '1-2 Hours After Lunch',
            ],
            [
                'id' => 5,
                'checking_type' => 'Before Dinner',
            ],
            [
                'id' => 6,
                'checking_type' => '1-2 Hours After Dinner',
            ],
            [
                'id' => 7,
                'checking_type' => 'Before Night Sleep',
            ],
        ];
        $this->db->table('checking_type')->insertBatch($data);
    }
}
