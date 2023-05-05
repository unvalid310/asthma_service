<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgeRangeSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'age' => '6 years old',
            ],
            [
                'id' => 2,
                'age' => '12 to 12 years old',
            ],
            [
                'id' => 3,
                'age' => '13 to 19 years old',
            ],
            [
                'id' => 4,
                'age' => 'More than 20 years old years old',
            ],
        ];
        $this->db->table('age_range')->insertBatch($data);
    }
}
